@extends('layouts.app')

@section('title', 'Tambah Anggota')
@section('page-title', 'Tambah Anggota')
@section('page-subtitle', 'Buat akun anggota baru')

@section('content')

<div class="max-w-lg">
    <div class="bg-white rounded-xl border border-slate-200 p-6">

        <form action="{{ route('admin.anggota.store') }}" method="POST" class="space-y-5">
            @csrf

            {{-- Nama --}}
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">
                    Nama Lengkap <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" value="{{ old('name') }}"
                       placeholder="Masukkan nama lengkap"
                       class="w-full px-3 py-2 rounded-lg border text-sm transition
                              {{ $errors->has('name') ? 'border-red-400 bg-red-50' : 'border-slate-300 focus:border-blue-500' }}
                              focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                @error('name')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">
                    Email <span class="text-red-500">*</span>
                </label>
                <input type="email" name="email" value="{{ old('email') }}"
                       placeholder="contoh@email.com"
                       class="w-full px-3 py-2 rounded-lg border text-sm transition
                              {{ $errors->has('email') ? 'border-red-400 bg-red-50' : 'border-slate-300 focus:border-blue-500' }}
                              focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                @error('email')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Role --}}
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">
                    Role <span class="text-red-500">*</span>
                </label>
                <select name="role"
                        class="w-full px-3 py-2 rounded-lg border text-sm transition
                               {{ $errors->has('role') ? 'border-red-400 bg-red-50' : 'border-slate-300 focus:border-blue-500' }}
                               focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                    <option value="">-- Pilih role --</option>
                    <option value="peminjam" {{ old('role') === 'peminjam' ? 'selected' : '' }}>Peminjam</option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                @error('role')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">
                    Password <span class="text-red-500">*</span>
                </label>
                <input type="password" name="password"
                       placeholder="Minimal 8 karakter"
                       class="w-full px-3 py-2 rounded-lg border text-sm transition
                              {{ $errors->has('password') ? 'border-red-400 bg-red-50' : 'border-slate-300 focus:border-blue-500' }}
                              focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                @error('password')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Konfirmasi Password --}}
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">
                    Konfirmasi Password <span class="text-red-500">*</span>
                </label>
                <input type="password" name="password_confirmation"
                       placeholder="Ulangi password"
                       class="w-full px-3 py-2 rounded-lg border text-sm transition
                              border-slate-300 focus:border-blue-500
                              focus:outline-none focus:ring-2 focus:ring-blue-500/20">
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-5 py-2 rounded-lg transition">
                    Simpan Anggota
                </button>
                <a href="{{ route('admin.anggota.index') }}"
                   class="text-sm text-slate-500 hover:text-slate-700 transition">
                    Batal
                </a>
            </div>

        </form>
    </div>
</div>

@endsection
