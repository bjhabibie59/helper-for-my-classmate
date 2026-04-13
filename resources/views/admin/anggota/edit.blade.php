@extends('layouts.app')

@section('title', 'Edit Anggota')
@section('page-title', 'Edit Anggota')
@section('page-subtitle', 'Perbarui data anggota: {{ $anggota->name }}')

@section('content')

<div class="max-w-lg">
    <div class="bg-white rounded-xl border border-slate-200 p-6">

        <form action="{{ route('admin.anggota.update', $anggota) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            {{-- Nama --}}
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">
                    Nama Lengkap <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" value="{{ old('name', $anggota->name) }}"
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
                <input type="email" name="email" value="{{ old('email', $anggota->email) }}"
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
                               focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                        {{ $anggota->id === auth()->id() ? 'disabled' : '' }}>
                    <option value="peminjam" {{ old('role', $anggota->role) === 'peminjam' ? 'selected' : '' }}>Peminjam</option>
                    <option value="admin" {{ old('role', $anggota->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                @if($anggota->id === auth()->id())
                    {{-- Kirim value role via hidden input jika disabled --}}
                    <input type="hidden" name="role" value="{{ $anggota->role }}">
                    <p class="mt-1 text-xs text-slate-400">Role Anda sendiri tidak dapat diubah.</p>
                @endif
                @error('role')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Info password --}}
            <div class="bg-slate-50 border border-slate-200 rounded-lg px-4 py-3 text-xs text-slate-500">
                🔒 Password tidak ditampilkan di sini. Biarkan kosong jika tidak ingin mengubah password.
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-5 py-2 rounded-lg transition">
                    Simpan Perubahan
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
