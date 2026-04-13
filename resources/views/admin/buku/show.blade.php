@extends('layouts.app')

@section('title', $buku->judul)
@section('page-title', 'Detail Buku')
@section('page-subtitle', $buku->judul)

@section('content')

<div class="grid grid-cols-3 gap-5">

    {{-- Info Buku --}}
    <div class="col-span-2 space-y-5">
        <div class="bg-white rounded-xl border border-slate-200 p-6">
            <div class="flex items-start justify-between mb-4">
                <h3 class="text-lg font-semibold text-slate-800">{{ $buku->judul }}</h3>
                <a href="{{ route('admin.buku.edit', $buku) }}"
                   class="text-xs text-blue-600 hover:text-blue-800 font-medium transition">Edit</a>
            </div>

            <dl class="grid grid-cols-2 gap-x-6 gap-y-4 text-sm">
                <div>
                    <dt class="text-slate-500 font-medium mb-0.5">Penulis</dt>
                    <dd class="text-slate-800">{{ $buku->penulis }}</dd>
                </div>
                <div>
                    <dt class="text-slate-500 font-medium mb-0.5">Penerbit</dt>
                    <dd class="text-slate-800">{{ $buku->penerbit }}</dd>
                </div>
                <div>
                    <dt class="text-slate-500 font-medium mb-0.5">Tahun Terbit</dt>
                    <dd class="text-slate-800">{{ $buku->tahun_terbit }}</dd>
                </div>
                <div>
                    <dt class="text-slate-500 font-medium mb-0.5">ISBN</dt>
                    <dd class="text-slate-800 font-mono">{{ $buku->isbn }}</dd>
                </div>
                <div>
                    <dt class="text-slate-500 font-medium mb-0.5">Total Stok</dt>
                    <dd class="text-slate-800">{{ $buku->stok }} eksemplar</dd>
                </div>
                <div>
                    <dt class="text-slate-500 font-medium mb-0.5">Stok Tersedia</dt>
                    <dd>
                        <span class="inline-block px-2 py-0.5 rounded-full text-xs font-semibold
                            {{ $buku->available_stock > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' }}">
                            {{ $buku->available_stock }} tersedia
                        </span>
                    </dd>
                </div>
            </dl>

            <div class="mt-4 pt-4 border-t border-slate-100">
                <dt class="text-slate-500 font-medium text-sm mb-1">Deskripsi</dt>
                <dd class="text-slate-700 text-sm leading-relaxed">{{ $buku->deskripsi }}</dd>
            </div>
        </div>
    </div>

    {{-- Sidebar: Sedang Dipinjam --}}
    <div class="col-span-1">
        <div class="bg-white rounded-xl border border-slate-200 p-5">
            <h4 class="text-sm font-semibold text-slate-700 mb-3">
                Sedang Dipinjam
                <span class="ml-1.5 bg-slate-100 text-slate-500 text-xs font-medium px-2 py-0.5 rounded-full">
                    {{ $buku->transaksiBerlangsung->count() }}
                </span>
            </h4>

            @forelse($buku->transaksiBerlangsung as $transaksi)
                <div class="py-2.5 border-b border-slate-100 last:border-0">
                    <p class="text-sm font-medium text-slate-800">{{ $transaksi->user->name }}</p>
                    <p class="text-xs text-slate-400 mt-0.5">
                        Kembali: {{ $transaksi->tanggal_pengembalian->format('d M Y') }}
                    </p>
                </div>
            @empty
                <p class="text-sm text-slate-400 py-4 text-center">Tidak ada peminjaman aktif</p>
            @endforelse
        </div>

        <div class="mt-3">
            <a href="{{ route('admin.buku.index') }}"
               class="text-sm text-slate-500 hover:text-slate-700 transition flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali ke daftar buku
            </a>
        </div>
    </div>

</div>

@endsection