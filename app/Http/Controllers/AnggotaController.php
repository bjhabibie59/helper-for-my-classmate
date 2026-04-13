<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AnggotaController extends Controller
{
    /**
     * Tampilkan daftar semua anggota.
     * Route: GET /admin/anggota
     */
    public function index()
    {
        $anggota = User::latest()->paginate(10);

        return view('admin.anggota.index', compact('anggota'));
    }

    /**
     * Tampilkan form tambah anggota.
     * Route: GET /admin/anggota/create
     */
    public function create()
    {
        return view('admin.anggota.create');
    }

    /**
     * Simpan anggota baru.
     * Route: POST /admin/anggota
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role'     => 'required|in:admin,peminjam',
        ]);

        User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => $validated['role'],
        ]);

        return redirect()->route('admin.anggota.index')
            ->with('success', 'Anggota berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit anggota.
     * Route: GET /admin/anggota/{user}/edit
     */
    public function edit(User $anggota)
    {
        return view('admin.anggota.edit', compact('anggota'));
    }

    /**
     * Update data anggota.
     * Route: PUT /admin/anggota/{user}
     */
    public function update(Request $request, User $anggota)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $anggota->id,
            'role'  => 'required|in:admin,peminjam',
        ]);

        $anggota->update($validated);

        return redirect()->route('admin.anggota.index')
            ->with('success', 'Data anggota berhasil diperbarui.');
    }

    /**
     * Hapus anggota.
     * Route: DELETE /admin/anggota/{user}
     */
    public function destroy(User $anggota)
    {
        // Cegah admin menghapus dirinya sendiri
        if ($anggota->id === auth()->id()) {
            return redirect()->route('admin.anggota.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        // Cegah hapus jika masih punya peminjaman aktif
        if ($anggota->activeTransaksis()->exists()) {
            return redirect()->route('admin.anggota.index')
                ->with('error', 'Anggota tidak dapat dihapus karena masih memiliki peminjaman aktif.');
        }

        $anggota->delete();

        return redirect()->route('admin.anggota.index')
            ->with('success', 'Anggota berhasil dihapus.');
    }
}
