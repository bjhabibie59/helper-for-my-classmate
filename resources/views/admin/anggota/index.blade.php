@extends('layouts.app')

@section('title', 'Kelola Anggota')
@section('page-title', 'Kelola Anggota')
@section('page-subtitle', 'Kelola seluruh akun anggota perpustakaan')

@section('content')

<div class="flex items-center justify-between mb-5">
    <p class="text-sm text-slate-500">Total <span class="font-semibold text-slate-700">{{ $anggota->total() }}</span> anggota</p>
    <a href="{{ route('admin.anggota.create') }}"
       class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Tambah Anggota
    </a>
</div>

<div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="bg-slate-50 border-b border-slate-200 text-left">
                <th class="px-4 py-3 font-semibold text-slate-600 w-8">#</th>
                <th class="px-4 py-3 font-semibold text-slate-600">Nama</th>
                <th class="px-4 py-3 font-semibold text-slate-600">Email</th>
                <th class="px-4 py-3 font-semibold text-slate-600 text-center">Role</th>
                <th class="px-4 py-3 font-semibold text-slate-600 text-center">Terdaftar</th>
                <th class="px-4 py-3 font-semibold text-slate-600 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($anggota as $user)
            <tr class="hover:bg-slate-50 transition">
                <td class="px-4 py-3 text-slate-400">
                    {{ $loop->iteration + ($anggota->currentPage() - 1) * $anggota->perPage() }}
                </td>
                <td class="px-4 py-3">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-sm font-bold text-blue-600 flex-shrink-0">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-medium text-slate-800">{{ $user->name }}</p>
                            @if($user->id === auth()->id())
                                <span class="text-xs text-blue-500 font-medium">(Anda)</span>
                            @endif
                        </div>
                    </div>
                </td>
                <td class="px-4 py-3 text-slate-600">{{ $user->email }}</td>
                <td class="px-4 py-3 text-center">
                    <span class="inline-block px-2 py-0.5 rounded-full text-xs font-semibold
                        {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-slate-100 text-slate-600' }}">
                        {{ ucfirst($user->role) }}
                    </span>
                </td>
                <td class="px-4 py-3 text-center text-slate-500 text-xs">
                    {{ $user->created_at->format('d M Y') }}
                </td>
                <td class="px-4 py-3">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('admin.anggota.edit', $user) }}"
                           class="text-slate-500 hover:text-yellow-600 transition" title="Edit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </a>

                        @if($user->id !== auth()->id())
                        <form action="{{ route('admin.anggota.destroy', $user) }}" method="POST"
                              onsubmit="return confirm('Yakin ingin menghapus anggota {{ $user->name }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-slate-500 hover:text-red-600 transition" title="Hapus">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </form>
                        @else
                        {{-- Placeholder agar layout tidak geser --}}
                        <span class="w-4 h-4 block"></span>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-4 py-12 text-center text-slate-400">
                    <svg class="w-10 h-10 mx-auto mb-2 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Belum ada anggota
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($anggota->hasPages())
<div class="mt-4">
    {{ $anggota->links() }}
</div>
@endif

@endsection
