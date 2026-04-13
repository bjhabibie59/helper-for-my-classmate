@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Selamat datang, {{ auth()->user()->name }}!')

@section('content')

{{-- Kartu Statistik --}}
<div class="grid grid-cols-3 gap-4 mb-6">
    <div class="bg-white border border-slate-200 rounded-xl px-5 py-4">
        <p class="text-xs text-slate-500 font-medium">Menunggu Persetujuan</p>
        <p class="text-3xl font-bold text-yellow-500 mt-1">{{ $jumlahDitunda }}</p>
    </div>
    <div class="bg-white border border-slate-200 rounded-xl px-5 py-4">
        <p class="text-xs text-slate-500 font-medium">Sedang Dipinjam</p>
        <p class="text-3xl font-bold text-blue-600 mt-1">{{ $jumlahDipinjam }}</p>
    </div>
    <div class="bg-white border border-slate-200 rounded-xl px-5 py-4">
        <p class="text-xs text-slate-500 font-medium">Total Riwayat</p>
        <p class="text-3xl font-bold text-slate-700 mt-1">{{ $totalTransaksi }}</p>
    </div>
</div>

<div class="grid grid-cols-3 gap-5">

    {{-- Peminjaman Aktif --}}
    <div class="col-span-2">
        <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                <h3 class="text-sm font-semibold text-slate-700">Peminjaman Aktif</h3>
                <a href="{{ route('peminjam.transaksi.riwayat') }}" class="text-xs text-blue-600 hover:text-blue-800 font-medium transition">
                    Lihat semua →
                </a>
            </div>

            @forelse($transaksiAktif as $transaksi)
            <div class="px-5 py-4 border-b border-slate-100 last:border-0 flex items-center gap-4">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-slate-800 truncate">{{ $transaksi->buku->judul }}</p>
                    <p class="text-xs text-slate-400 mt-0.5">{{ $transaksi->buku->penulis }}</p>
                </div>
                <div class="text-right flex-shrink-0">
                    <p class="text-xs text-slate-500">Kembali paling lambat</p>
                    <p class="text-sm font-semibold {{ $transaksi->tanggal_pengembalian->isPast() ? 'text-red-600' : 'text-slate-700' }} mt-0.5">
                        {{ $transaksi->tanggal_pengembalian->format('d M Y') }}
                    </p>
                    @if($transaksi->tanggal_pengembalian->isPast())
                        <p class="text-xs text-red-500 font-medium mt-0.5">⚠ Terlambat</p>
                    @else
                        <p class="text-xs text-slate-400 mt-0.5">{{ $transaksi->tanggal_pengembalian->diffForHumans() }}</p>
                    @endif
                </div>
            </div>
            @empty
            <div class="px-5 py-10 text-center text-slate-400">
                <svg class="w-8 h-8 mx-auto mb-2 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                <p class="text-sm">Tidak ada peminjaman aktif</p>
            </div>
            @endforelse
        </div>
    </div>

    {{-- Shortcut --}}
    <div class="col-span-1 space-y-3">
        <a href="{{ route('peminjam.buku.index') }}"
           class="flex items-center gap-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl px-5 py-4 transition">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
            <div>
                <p class="text-sm font-semibold">Lihat Koleksi Buku</p>
                <p class="text-xs text-blue-200 mt-0.5">Cari & pinjam buku</p>
            </div>
        </a>

        <a href="{{ route('peminjam.transaksi.riwayat') }}"
           class="flex items-center gap-3 bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 rounded-xl px-5 py-4 transition">
            <svg class="w-5 h-5 flex-shrink-0 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <p class="text-sm font-semibold">Riwayat Peminjaman</p>
                <p class="text-xs text-slate-400 mt-0.5">Lihat semua transaksi</p>
            </div>
        </a>

        {{-- Info ditunda --}}
        @if($jumlahDitunda > 0)
        <div class="bg-yellow-50 border border-yellow-200 rounded-xl px-5 py-4">
            <p class="text-xs font-semibold text-yellow-800">⏳ {{ $jumlahDitunda }} permohonan menunggu</p>
            <p class="text-xs text-yellow-600 mt-1">Admin sedang memproses permohonan peminjaman Anda.</p>
        </div>
        @endif
    </div>

</div>

@endsection
