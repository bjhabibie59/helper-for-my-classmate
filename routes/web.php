<?php

use App\Http\Controllers\BukuController;
use App\Http\Controllers\PeminjamController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// -----------------------------------------------------------------------
// Route khusus Admin
// -----------------------------------------------------------------------
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {

    // Manajemen Buku (CRUD)
    Route::resource('buku', BukuController::class);

    // Manajemen Transaksi
    Route::get('transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('transaksi/{transaksi}', [TransaksiController::class, 'show'])->name('transaksi.show');
    Route::patch('transaksi/{transaksi}/status', [TransaksiController::class, 'updateStatus'])->name('transaksi.updateStatus');
});

// -----------------------------------------------------------------------
// Route khusus Peminjam
// -----------------------------------------------------------------------
Route::prefix('peminjam')->name('peminjam.')->middleware(['auth', 'role:peminjam'])->group(function () {

    // Dashboard
    Route::get('dashboard', [PeminjamController::class, 'dashboard'])->name('dashboard');

    // Koleksi buku
    Route::get('buku', [PeminjamController::class, 'bukuIndex'])->name('buku.index');

    // Ajukan peminjaman
    Route::get('transaksi/create', [TransaksiController::class, 'create'])->name('transaksi.create');
    Route::post('transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');

    // Riwayat peminjaman sendiri
    Route::get('transaksi/riwayat', [TransaksiController::class, 'riwayat'])->name('transaksi.riwayat');
});

require __DIR__.'/auth.php';
