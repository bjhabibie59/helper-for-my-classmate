@extends('layouts.app')

@section('title', 'Riwayat Peminjaman')
@section('page-title', 'Riwayat Peminjaman')
@section('page-subtitle', 'Seluruh riwayat peminjaman buku Anda')

@section('content')

<div class="flex items-center justify-between mb-5">
    <p class="text-sm text-slate-500">
        Total <span class="font-semibold text-slate-700">{{ $transaksis->total() }}</span> transaksi
    </p>
    <a href="{{ route('transaksi.create') }}"
       class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Pinjam Buku Baru
    </a>
</div>

<div class="space-y-3">
    @forelse($transaksis as $transaksi)
    <div class="bg-white rounded-xl border border-slate-200 px-5 py-4 flex items-center gap-5">

        {{-- Status Badge --}}
        <div class="flex-shrink-0">
            @php
                $badgeClass = match($transaksi->status) {
                    'ditunda'      => 'bg-yellow-100 text-yellow-700',
                    'dipinjam'     => 'bg-blue-100 text-blue-700',
                    'dikembalikan' => 'bg-green-100 text-green-700',
                    default        => 'bg-slate-100 text-slate-600',
                };
                $label = match($transaksi->status) {
                    'ditunda'      => 'Menunggu',
                    'dipinjam'     => 'Dipinjam',
                    'dikembalikan' => 'Dikembalikan',
                    default        => $transaksi->status,
                };
            @endphp
            <span class="inline-block px-2.5 py-1 rounded-full text-xs font-semibold {{ $badgeClass }}">
                {{ $label }}
            </span>
        </div>

        {{-- Info --}}
        <div class="flex-1 min-w-0">
            <p class="font-medium text-slate-800 text-sm">{{ $transaksi->buku->judul }}</p>
            <p class="text-xs text-slate-400 mt-0.5">{{ $transaksi->buku->penulis }}</p>
        </div>

        {{-- Tanggal --}}
        <div class="text-right flex-shrink-0">
            <p class="text-xs text-slate-500">
                Pinjam: <span class="text-slate-700 font-medium">{{ $transaksi->tanggal_peminjaman->format('d M Y') }}</span>
            </p>
            <p class="text-xs text-slate-500 mt-0.5">
                Kembali: <span class="text-slate-700 font-medium">{{ $transaksi->tanggal_pengembalian->format('d M Y') }}</span>
            </p>

            {{-- Overdue warning --}}
            @if($transaksi->status === 'dipinjam' && $transaksi->tanggal_pengembalian->isPast())
                <p class="text-xs text-red-500 font-medium mt-1">⚠ Terlambat dikembalikan</p>
            @endif
        </div>

    </div>
    @empty
    <div class="bg-white rounded-xl border border-slate-200 px-5 py-16 text-center">
        <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <p class="text-slate-500 font-medium text-sm">Belum ada riwayat peminjaman</p>
        <p class="text-slate-400 text-xs mt-1">Yuk, mulai pinjam buku pertama Anda!</p>
        <a href="{{ route('transaksi.create') }}"
           class="inline-block mt-4 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
            Pinjam Sekarang
        </a>
    </div>
    @endforelse
</div>

@if($transaksis->hasPages())
<div class="mt-4">
    {{ $transaksis->links() }}
</div>
@endif

@endsection