@extends('layouts.app')

@section('title', 'Detail Transaksi')
@section('page-title', 'Detail Transaksi')
@section('page-subtitle', 'Informasi lengkap dan pengelolaan status peminjaman')

@section('content')

<div class="grid grid-cols-3 gap-5">

    {{-- Detail Transaksi --}}
    <div class="col-span-2 space-y-5">

        {{-- Info Peminjam --}}
        <div class="bg-white rounded-xl border border-slate-200 p-6">
            <h3 class="text-sm font-semibold text-slate-700 mb-4 uppercase tracking-wide">Informasi Peminjam</h3>
            <dl class="grid grid-cols-2 gap-x-6 gap-y-3 text-sm">
                <div>
                    <dt class="text-slate-500 mb-0.5">Nama</dt>
                    <dd class="font-medium text-slate-800">{{ $transaksi->user->name }}</dd>
                </div>
                <div>
                    <dt class="text-slate-500 mb-0.5">Email</dt>
                    <dd class="text-slate-800">{{ $transaksi->user->email }}</dd>
                </div>
            </dl>
        </div>

        {{-- Info Buku --}}
        <div class="bg-white rounded-xl border border-slate-200 p-6">
            <h3 class="text-sm font-semibold text-slate-700 mb-4 uppercase tracking-wide">Informasi Buku</h3>
            <dl class="grid grid-cols-2 gap-x-6 gap-y-3 text-sm">
                <div>
                    <dt class="text-slate-500 mb-0.5">Judul</dt>
                    <dd class="font-medium text-slate-800">{{ $transaksi->buku->judul }}</dd>
                </div>
                <div>
                    <dt class="text-slate-500 mb-0.5">Penulis</dt>
                    <dd class="text-slate-800">{{ $transaksi->buku->penulis }}</dd>
                </div>
                <div>
                    <dt class="text-slate-500 mb-0.5">ISBN</dt>
                    <dd class="text-slate-800 font-mono">{{ $transaksi->buku->isbn }}</dd>
                </div>
                <div>
                    <dt class="text-slate-500 mb-0.5">Penerbit</dt>
                    <dd class="text-slate-800">{{ $transaksi->buku->penerbit }}</dd>
                </div>
            </dl>
        </div>

        {{-- Info Peminjaman --}}
        <div class="bg-white rounded-xl border border-slate-200 p-6">
            <h3 class="text-sm font-semibold text-slate-700 mb-4 uppercase tracking-wide">Informasi Peminjaman</h3>
            <dl class="grid grid-cols-3 gap-x-6 gap-y-3 text-sm">
                <div>
                    <dt class="text-slate-500 mb-0.5">Tanggal Pinjam</dt>
                    <dd class="font-medium text-slate-800">{{ $transaksi->tanggal_peminjaman->format('d M Y') }}</dd>
                </div>
                <div>
                    <dt class="text-slate-500 mb-0.5">Tanggal Kembali</dt>
                    <dd class="font-medium text-slate-800">{{ $transaksi->tanggal_pengembalian->format('d M Y') }}</dd>
                </div>
                <div>
                    <dt class="text-slate-500 mb-0.5">Status Saat Ini</dt>
                    <dd>
                        @php
                            $badgeClass = match($transaksi->status) {
                                'ditunda'      => 'bg-yellow-100 text-yellow-700',
                                'dipinjam'     => 'bg-blue-100 text-blue-700',
                                'dikembalikan' => 'bg-green-100 text-green-700',
                                default        => 'bg-slate-100 text-slate-600',
                            };
                            $label = match($transaksi->status) {
                                'ditunda'      => 'Menunggu Persetujuan',
                                'dipinjam'     => 'Sedang Dipinjam',
                                'dikembalikan' => 'Sudah Dikembalikan',
                                default        => $transaksi->status,
                            };
                        @endphp
                        <span class="inline-block px-2 py-0.5 rounded-full text-xs font-semibold {{ $badgeClass }}">
                            {{ $label }}
                        </span>
                    </dd>
                </div>
            </dl>
        </div>

    </div>

    {{-- Sidebar: Update Status --}}
    <div class="col-span-1 space-y-4">

        @if($transaksi->status !== 'dikembalikan')
        <div class="bg-white rounded-xl border border-slate-200 p-5">
            <h4 class="text-sm font-semibold text-slate-700 mb-4">Ubah Status</h4>

            <form action="{{ route('admin.transaksi.updateStatus', $transaksi) }}" method="POST" class="space-y-3">
                @csrf
                @method('PATCH')

                <div>
                    <label class="block text-xs font-medium text-slate-600 mb-1.5">Pilih status baru</label>
                    <select name="status"
                            class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 transition">
                        @if($transaksi->status === 'ditunda')
                            <option value="dipinjam">✅ Setujui (Dipinjam)</option>
                            <option value="ditunda" selected>⏳ Tetap Menunggu</option>
                        @elseif($transaksi->status === 'dipinjam')
                            <option value="dikembalikan">📦 Tandai Dikembalikan</option>
                        @endif
                    </select>
                </div>

                <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2 rounded-lg transition">
                    Simpan Status
                </button>
            </form>
        </div>
        @else
        <div class="bg-green-50 border border-green-200 rounded-xl p-5 text-center">
            <svg class="w-8 h-8 text-green-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            <p class="text-sm font-medium text-green-800">Transaksi Selesai</p>
            <p class="text-xs text-green-600 mt-0.5">Buku sudah dikembalikan</p>
        </div>
        @endif

        <a href="{{ route('admin.transaksi.index') }}"
           class="text-sm text-slate-500 hover:text-slate-700 transition flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke daftar transaksi
        </a>

    </div>

</div>

@endsection