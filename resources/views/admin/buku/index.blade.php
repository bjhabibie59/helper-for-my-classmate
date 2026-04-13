@extends('layouts.app')

@section('title', 'Manajemen Buku')
@section('page-title', 'Manajemen Buku')
@section('page-subtitle', 'Kelola seluruh koleksi buku perpustakaan')

@section('content')

<div class="flex items-center justify-between mb-5">
    <p class="text-sm text-slate-500">Total <span class="font-semibold text-slate-700">{{ $bukus->total() }}</span> buku</p>
    <a href="{{ route('admin.buku.create') }}"
       class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Tambah Buku
    </a>
</div>

<div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="bg-slate-50 border-b border-slate-200 text-left">
                <th class="px-4 py-3 font-semibold text-slate-600 w-8">#</th>
                <th class="px-4 py-3 font-semibold text-slate-600">Judul</th>
                <th class="px-4 py-3 font-semibold text-slate-600">Penulis</th>
                <th class="px-4 py-3 font-semibold text-slate-600">ISBN</th>
                <th class="px-4 py-3 font-semibold text-slate-600 text-center">Stok</th>
                <th class="px-4 py-3 font-semibold text-slate-600 text-center">Tersedia</th>
                <th class="px-4 py-3 font-semibold text-slate-600 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($bukus as $buku)
            <tr class="hover:bg-slate-50 transition">
                <td class="px-4 py-3 text-slate-400">{{ $loop->iteration + ($bukus->currentPage() - 1) * $bukus->perPage() }}</td>
                <td class="px-4 py-3">
                    <p class="font-medium text-slate-800">{{ $buku->judul }}</p>
                    <p class="text-xs text-slate-400">{{ $buku->penerbit }}, {{ $buku->tahun_terbit }}</p>
                </td>
                <td class="px-4 py-3 text-slate-600">{{ $buku->penulis }}</td>
                <td class="px-4 py-3 text-slate-500 font-mono text-xs">{{ $buku->isbn }}</td>
                <td class="px-4 py-3 text-center text-slate-600">{{ $buku->stok }}</td>
                <td class="px-4 py-3 text-center">
                    @php $tersedia = $buku->available_stock @endphp
                    <span class="inline-block px-2 py-0.5 rounded-full text-xs font-semibold
                        {{ $tersedia > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' }}">
                        {{ $tersedia }}
                    </span>
                </td>
                <td class="px-4 py-3">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('admin.buku.show', $buku) }}"
                           class="text-slate-500 hover:text-blue-600 transition" title="Detail">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </a>
                        <a href="{{ route('admin.buku.edit', $buku) }}"
                           class="text-slate-500 hover:text-yellow-600 transition" title="Edit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </a>
                        <form action="{{ route('admin.buku.destroy', $buku) }}" method="POST"
                              onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-slate-500 hover:text-red-600 transition" title="Hapus">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-4 py-12 text-center text-slate-400">
                    <svg class="w-10 h-10 mx-auto mb-2 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    Belum ada buku
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Pagination --}}
@if($bukus->hasPages())
<div class="mt-4">
    {{ $bukus->links() }}
</div>
@endif

@endsection