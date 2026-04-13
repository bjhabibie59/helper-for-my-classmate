@extends('layouts.app')

@section('title', 'Tambah Buku')
@section('page-title', 'Tambah Buku')
@section('page-subtitle', 'Tambahkan buku baru ke koleksi perpustakaan')

@section('content')

<div class="max-w-2xl">
    <div class="bg-white rounded-xl border border-slate-200 p-6">

        <form action="{{ route('admin.buku.store') }}" method="POST" class="space-y-5">
            @csrf

            {{-- Judul --}}
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Judul Buku <span class="text-red-500">*</span></label>
                <input type="text" name="judul" value="{{ old('judul') }}"
                       placeholder="Masukkan judul buku"
                       class="w-full px-3 py-2 rounded-lg border text-sm transition
                              {{ $errors->has('judul') ? 'border-red-400 bg-red-50' : 'border-slate-300 focus:border-blue-500' }}
                              focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                @error('judul')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Penulis & Penerbit --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Penulis <span class="text-red-500">*</span></label>
                    <input type="text" name="penulis" value="{{ old('penulis') }}"
                           placeholder="Nama penulis"
                           class="w-full px-3 py-2 rounded-lg border text-sm transition
                                  {{ $errors->has('penulis') ? 'border-red-400 bg-red-50' : 'border-slate-300 focus:border-blue-500' }}
                                  focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                    @error('penulis')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Penerbit <span class="text-red-500">*</span></label>
                    <input type="text" name="penerbit" value="{{ old('penerbit') }}"
                           placeholder="Nama penerbit"
                           class="w-full px-3 py-2 rounded-lg border text-sm transition
                                  {{ $errors->has('penerbit') ? 'border-red-400 bg-red-50' : 'border-slate-300 focus:border-blue-500' }}
                                  focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                    @error('penerbit')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Tahun Terbit & ISBN --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Tahun Terbit <span class="text-red-500">*</span></label>
                    <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit') }}"
                           placeholder="contoh: 2020" min="1900" max="{{ date('Y') }}"
                           class="w-full px-3 py-2 rounded-lg border text-sm transition
                                  {{ $errors->has('tahun_terbit') ? 'border-red-400 bg-red-50' : 'border-slate-300 focus:border-blue-500' }}
                                  focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                    @error('tahun_terbit')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">ISBN <span class="text-red-500">*</span></label>
                    <input type="text" name="isbn" value="{{ old('isbn') }}"
                           placeholder="contoh: 978-3-16-148410-0"
                           class="w-full px-3 py-2 rounded-lg border text-sm font-mono transition
                                  {{ $errors->has('isbn') ? 'border-red-400 bg-red-50' : 'border-slate-300 focus:border-blue-500' }}
                                  focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                    @error('isbn')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Stok --}}
            <div class="w-1/2 pr-2">
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Stok <span class="text-red-500">*</span></label>
                <input type="number" name="stok" value="{{ old('stok', 1) }}"
                       min="0"
                       class="w-full px-3 py-2 rounded-lg border text-sm transition
                              {{ $errors->has('stok') ? 'border-red-400 bg-red-50' : 'border-slate-300 focus:border-blue-500' }}
                              focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                @error('stok')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Deskripsi --}}
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Deskripsi <span class="text-red-500">*</span></label>
                <textarea name="deskripsi" rows="4"
                          placeholder="Tulis deskripsi singkat tentang buku ini..."
                          class="w-full px-3 py-2 rounded-lg border text-sm transition resize-none
                                 {{ $errors->has('deskripsi') ? 'border-red-400 bg-red-50' : 'border-slate-300 focus:border-blue-500' }}
                                 focus:outline-none focus:ring-2 focus:ring-blue-500/20">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-5 py-2 rounded-lg transition">
                    Simpan Buku
                </button>
                <a href="{{ route('admin.buku.index') }}"
                   class="text-sm text-slate-500 hover:text-slate-700 transition">
                    Batal
                </a>
            </div>

        </form>
    </div>
</div>

@endsection