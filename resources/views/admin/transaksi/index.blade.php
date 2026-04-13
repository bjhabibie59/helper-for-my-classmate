@extends('layouts.app')

@section('title', 'Semua Transaksi')
@section('page-title', 'Semua Transaksi')
@section('page-subtitle', 'Pantau dan kelola seluruh aktivitas peminjaman')

@section('content')

{{-- Statistik cepat --}}
<div class="grid grid-cols-3 gap-4 mb-5">
    @php
        $semuaStatus = $transaksis->groupBy('status');
    @endphp
    <div class="bg-white border border-slate-200 rounded-xl px-5 py-4">
        <p class="text-xs text-slate-500 font-medium">Menunggu</p>
        <p class="text-2xl font-bold text-slate-800 mt-1">{{ $transaksis->where('status', 'ditunda')->count() }}</p>
    </div>
    <div class="bg-white border border-slate-200 rounded-xl px-5 py-4">
        <p class="text-xs text-slate-500 font-medium">Sedang Dipinjam</p>
        <p class="text-2xl font-bold text-blue-600 mt-1">{{ $transaksis->where('status', 'dipinjam')->count() }}</p>
    </div>
    <div class="bg-white border border-slate-200 rounded-xl px-5 py-4">
        <p class="text-xs text-slate-500 font-medium">Dikembalikan</p>
        <p class="text-2xl font-bold text-green-600 mt-1">{{ $transaksis->where('status', 'dikembalikan')->count() }}</p>
    </div>
</div>

<div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="bg-slate-50 border-b border-slate-200 text-left">
                <th class="px-4 py-3 font-semibold text-slate-600">#</th>
                <th class="px-4 py-3 font-semibold text-slate-600">Peminjam</th>
                <th class="px-4 py-3 font-semibold text-slate-600">Buku</th>
                <th class="px-4 py-3 font-semibold text-slate-600">Tgl Pinjam</th>
                <th class="px-4 py-3 font-semibold text-slate-600">Tgl Kembali</th>
                <th class="px-4 py-3 font-semibold text-slate-600 text-center">Status</th>
                <th class="px-4 py-3 font-semibold text-slate-600 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($transaksis as $transaksi)
            <tr class="hover:bg-slate-50 transition">
                <td class="px-4 py-3 text-slate-400">{{ $loop->iteration + ($transaksis->currentPage() - 1) * $transaksis->perPage() }}</td>
                <td class="px-4 py-3">
                    <p class="font-medium text-slate-800">{{ $transaksi->user->name }}</p>
                    <p class="text-xs text-slate-400">{{ $transaksi->user->email }}</p>
                </td>
                <td class="px-4 py-3 text-slate-700">{{ $transaksi->buku->judul }}</td>
                <td class="px-4 py-3 text-slate-600">{{ $transaksi->tanggal_peminjaman->format('d M Y') }}</td>
                <td class="px-4 py-3 text-slate-600">{{ $transaksi->tanggal_pengembalian->format('d M Y') }}</td>
                <td class="px-4 py-3 text-center">
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
                    <span class="inline-block px-2 py-0.5 rounded-full text-xs font-semibold {{ $badgeClass }}">
                        {{ $label }}
                    </span>
                </td>
                <td class="px-4 py-3 text-right">
                    <a href="{{ route('admin.transaksi.show', $transaksi) }}"
                       class="text-xs text-blue-600 hover:text-blue-800 font-medium transition">
                        Detail
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-4 py-12 text-center text-slate-400">
                    <svg class="w-10 h-10 mx-auto mb-2 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    Belum ada transaksi
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($transaksis->hasPages())
<div class="mt-4">
    {{ $transaksis->links() }}
</div>
@endif

@endsection