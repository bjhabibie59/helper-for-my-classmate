<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

// Note: Request masih dipakai oleh store() dan update()

class BukuController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    /**
     * Tampilkan daftar semua buku.
     */
    public function index()
    {
        $bukus = Buku::latest()->paginate(10);

        return view('admin.buku.index', compact('bukus'));
    }

    /**
     * Tampilkan form tambah buku.
     */
    public function create()
    {
        return view('admin.buku.create');
    }

    /**
     * Simpan buku baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'        => 'required|string|max:255',
            'penulis'      => 'required|string|max:255',
            'penerbit'     => 'required|string|max:255',
            'tahun_terbit' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'isbn'         => 'required|string|max:20|unique:bukus,isbn',
            'stok'         => 'required|integer|min:0',
            'deskripsi'    => 'required|string',
        ]);

        Buku::create($validated);

        return redirect()->route('admin.buku.index')
            ->with('success', 'Buku berhasil ditambahkan.');
    }

    /**
     * Tampilkan detail satu buku.
     */
    public function show(Buku $buku)
    {
        $buku->load('transaksiBerlangsung.user');

        return view('admin.buku.show', compact('buku'));
    }

    /**
     * Tampilkan form edit buku.
     */
    public function edit(Buku $buku)
    {
        return view('admin.buku.edit', compact('buku'));
    }

    /**
     * Update data buku di database.
     */
    public function update(Request $request, Buku $buku)
    {
        $validated = $request->validate([
            'judul'        => 'required|string|max:255',
            'penulis'      => 'required|string|max:255',
            'penerbit'     => 'required|string|max:255',
            'tahun_terbit' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'isbn'         => 'required|string|max:20|unique:bukus,isbn,' . $buku->id,
            'stok'         => 'required|integer|min:0',
            'deskripsi'    => 'required|string',
        ]);

        $buku->update($validated);

        return redirect()->route('admin.buku.index')
            ->with('success', 'Buku berhasil diperbarui.');
    }

    /**
     * Hapus buku dari database.
     */
    public function destroy(Buku $buku)
    {
        // Cegah hapus buku yang masih dipinjam
        if ($buku->transaksiBerlangsung()->exists()) {
            return redirect()->route('admin.buku.index')
                ->with('error', 'Buku tidak dapat dihapus karena masih ada yang meminjam.');
        }

        $buku->delete();

        return redirect()->route('admin.buku.index')
            ->with('success', 'Buku berhasil dihapus.');
    }
}
