@extends('layouts.app')

@section('title', 'Pinjam Buku')
@section('page-title', 'Pinjam Buku')
@section('page-subtitle', 'Ajukan permohonan peminjaman buku')

@section('content')

<div class="max-w-xl">
    <div class="bg-white rounded-xl border border-slate-200 p-6">

        <form action="{{ route('transaksi.store') }}" method="POST" class="space-y-5">
            @csrf

            {{-- Pilih Buku --}}
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">
                    Pilih Buku <span class="text-red-500">*</span>
                </label>
                <select name="buku_id"
                        class="w-full px-3 py-2 rounded-lg border text-sm transition
                               {{ $errors->has('buku_id') ? 'border-red-400 bg-red-50' : 'border-slate-300 focus:border-blue-500' }}
                               focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                    <option value="">-- Pilih buku yang tersedia --</option>
                    @foreach($bukus as $buku)
                        <option value="{{ $buku->id }}" {{ old('buku_id') == $buku->id ? 'selected' : '' }}>
                            {{ $buku->judul }} — {{ $buku->penulis }}
                            (Stok: {{ $buku->available_stock }})
                        </option>
                    @endforeach
                </select>
                @error('buku_id')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tanggal Pinjam --}}
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">
                    Tanggal Peminjaman <span class="text-red-500">*</span>
                </label>
                <input type="date" name="tanggal_peminjaman"
                       value="{{ old('tanggal_peminjaman', date('Y-m-d')) }}"
                       min="{{ date('Y-m-d') }}"
                       class="w-full px-3 py-2 rounded-lg border text-sm transition
                              {{ $errors->has('tanggal_peminjaman') ? 'border-red-400 bg-red-50' : 'border-slate-300 focus:border-blue-500' }}
                              focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                @error('tanggal_peminjaman')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tanggal Kembali --}}
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">
                    Tanggal Pengembalian <span class="text-red-500">*</span>
                </label>
                <input type="date" name="tanggal_pengembalian"
                       value="{{ old('tanggal_pengembalian') }}"
                       min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                       class="w-full px-3 py-2 rounded-lg border text-sm transition
                              {{ $errors->has('tanggal_pengembalian') ? 'border-red-400 bg-red-50' : 'border-slate-300 focus:border-blue-500' }}
                              focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                @error('tanggal_pengembalian')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Info --}}
            <div class="bg-blue-50 border border-blue-100 rounded-lg px-4 py-3 text-xs text-blue-700">
                ℹ️ Permohonan akan dikirim ke admin untuk disetujui terlebih dahulu sebelum buku dapat diambil.
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-3 pt-1">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-5 py-2 rounded-lg transition">
                    Ajukan Peminjaman
                </button>
                <a href="{{ route('transaksi.riwayat') }}"
                   class="text-sm text-slate-500 hover:text-slate-700 transition">
                    Lihat Riwayat
                </a>
            </div>

        </form>
    </div>
</div>

@endsection