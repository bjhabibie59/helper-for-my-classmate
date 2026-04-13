<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;

class PeminjamController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:peminjam']);
    }

    /**
     * Dashboard peminjam.
     * Route: GET /dashboard
     */
    public function dashboard()
    {
        $user = Auth::user();

        $transaksiAktif = Transaksi::with('buku')
            ->where('user_id', $user->id)
            ->where('status', 'dipinjam')
            ->latest()
            ->get();

        $jumlahDitunda  = Transaksi::where('user_id', $user->id)->where('status', 'ditunda')->count();
        $jumlahDipinjam = $transaksiAktif->count();
        $totalTransaksi = Transaksi::where('user_id', $user->id)->count();

        return view('peminjam.dashboard', compact(
            'transaksiAktif',
            'jumlahDitunda',
            'jumlahDipinjam',
            'totalTransaksi',
        ));
    }

    /**
     * Daftar buku tersedia untuk peminjam.
     * Route: GET /buku
     */
    public function bukuIndex()
    {
        $bukus = Buku::latest()->paginate(12);

        return view('peminjam.buku.index', compact('bukus'));
    }
}