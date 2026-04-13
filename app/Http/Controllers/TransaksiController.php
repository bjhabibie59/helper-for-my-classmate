<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    /**
     * Tampilkan daftar semua transaksi (admin).
     * Route: GET /admin/transaksi
     */
    public function index()
    {
        $this->middlewareRole('admin');

        $transaksis = Transaksi::with(['user', 'buku'])->latest()->paginate(10);

        return view('admin.transaksi.index', compact('transaksis'));
    }

    /**
     * Tampilkan form peminjaman buku (peminjam).
     * Route: GET /transaksi/create?buku_id=1
     */
    public function create()
    {
        $this->middlewareRole('peminjam');

        $bukus = Buku::where('stok', '>', 0)->orderBy('judul')->get();

        return view('admin.transaksi.create', compact('bukus'));
    }

    /**
     * Simpan transaksi peminjaman baru (peminjam).
     * Route: POST /transaksi
     */
    public function store(Request $request)
    {
        $this->middlewareRole('peminjam');

        $validated = $request->validate([
            'buku_id'              => 'required|exists:bukus,id',
            'tanggal_peminjaman'   => 'required|date|after_or_equal:today',
            'tanggal_pengembalian' => 'required|date|after:tanggal_peminjaman',
        ]);

        $buku = Buku::findOrFail($validated['buku_id']);

        // Cek ketersediaan stok
        if ($buku->available_stock <= 0) {
            return back()->withErrors(['buku_id' => 'Stok buku tidak tersedia saat ini.'])->withInput();
        }

        // Cek apakah peminjam sudah meminjam buku yang sama
        $sudahMeminjam = Transaksi::where('user_id', Auth::id())
            ->where('buku_id', $buku->id)
            ->where('status', 'dipinjam')
            ->exists();

        if ($sudahMeminjam) {
            return back()->withErrors(['buku_id' => 'Anda masih meminjam buku ini.'])->withInput();
        }

        Transaksi::create([
            'user_id'              => Auth::id(),
            'buku_id'              => $validated['buku_id'],
            'tanggal_peminjaman'   => $validated['tanggal_peminjaman'],
            'tanggal_pengembalian' => $validated['tanggal_pengembalian'],
            'status'               => 'ditunda', // menunggu persetujuan admin
        ]);

        return redirect()->route('peminjam.transaksi.riwayat')
            ->with('success', 'Permohonan peminjaman berhasil dikirim, menunggu persetujuan admin.');
    }

    /**
     * Tampilkan detail transaksi (admin).
     * Route: GET /admin/transaksi/{transaksi}
     */
    public function show(Transaksi $transaksi)
    {
        $this->middlewareRole('admin');

        $transaksi->load(['user', 'buku']);

        return view('admin.transaksi.show', compact('transaksi'));
    }

    /**
     * Update status transaksi (admin): approve / kembalikan / tolak.
     * Route: PATCH /admin/transaksi/{transaksi}/status
     */
    public function updateStatus(Request $request, Transaksi $transaksi)
    {
        $this->middlewareRole('admin');

        $validated = $request->validate([
            'status' => 'required|in:dipinjam,dikembalikan,ditunda',
        ]);

        $statusLama = $transaksi->status;
        $statusBaru = $validated['status'];

        // Aturan transisi status yang diperbolehkan
        $transisiValid = [
            'ditunda'     => ['dipinjam', 'ditunda'],   // approve atau tetap ditunda
            'dipinjam'    => ['dikembalikan'],            // hanya bisa dikembalikan
            'dikembalikan' => [],                         // final, tidak bisa diubah
        ];

        if (! in_array($statusBaru, $transisiValid[$statusLama] ?? [])) {
            return back()->with('error', "Status tidak dapat diubah dari '{$statusLama}' menjadi '{$statusBaru}'.");
        }

        $transaksi->update(['status' => $statusBaru]);

        $pesanSukses = match ($statusBaru) {
            'dipinjam'    => 'Peminjaman berhasil disetujui.',
            'dikembalikan' => 'Buku berhasil ditandai sebagai dikembalikan.',
            'ditunda'     => 'Status transaksi diperbarui.',
            default       => 'Status transaksi diperbarui.',
        };

        return redirect()->route('admin.transaksi.index')
            ->with('success', $pesanSukses);
    }

    /**
     * Riwayat transaksi milik peminjam yang sedang login.
     * Route: GET /transaksi/riwayat
     */
    public function riwayat()
    {
        $this->middlewareRole('peminjam');

        $transaksis = Transaksi::with('buku')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('admin.transaksi.riwayat', compact('transaksis'));
    }

    /**
     * Helper: cek role user yang sedang login.
     */
    private function middlewareRole(string $role): void
    {
        if (Auth::user()->role !== $role) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }
    }
}