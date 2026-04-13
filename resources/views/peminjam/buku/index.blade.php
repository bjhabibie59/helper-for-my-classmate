@extends('layouts.app')

@section('title', 'Koleksi Buku')
@section('page-title', 'Koleksi Buku')
@section('page-subtitle', 'Temukan dan pinjam buku yang Anda inginkan')

@section('content')

<div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
    @forelse($bukus as $buku)
    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden flex flex-col hover:shadow-md transition-shadow">

        {{-- Cover placeholder --}}
        <div class="bg-gradient-to-br from-slate-100 to-slate-200 h-36 flex items-center justify-center flex-shrink-0">
            <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
        </div>

        {{-- Info --}}
        <div class="p-4 flex flex-col flex-1">
            <h3 class="text-sm font-semibold text-slate-800 leading-snug line-clamp-2">{{ $buku->judul }}</h3>
            <p class="text-xs text-slate-500 mt-1">{{ $buku->penulis }}</p>
            <p class="text-xs text-slate-400 mt-0.5">{{ $buku->penerbit }}, {{ $buku->tahun_terbit }}</p>

            <div class="mt-auto pt-3">
                @php $tersedia = $buku->available_stock @endphp

                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs {{ $tersedia > 0 ? 'text-green-600' : 'text-red-500' }} font-medium">
                        {{ $tersedia > 0 ? $tersedia . ' tersedia' : 'Habis' }}
                    </span>
                    <span class="text-xs text-slate-400">Stok: {{ $buku->stok }}</span>
                </div>

                @if($tersedia > 0)
                    <a href="{{ route('peminjam.transaksi.create', ['buku_id' => $buku->id]) }}"
                       class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold py-2 rounded-lg transition">
                        Pinjam Sekarang
                    </a>
                @else
                    <button disabled
                            class="block w-full text-center bg-slate-100 text-slate-400 text-xs font-semibold py-2 rounded-lg cursor-not-allowed">
                        Tidak Tersedia
                    </button>
                @endif
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-full bg-white rounded-xl border border-slate-200 py-16 text-center text-slate-400">
        <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                  d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
        </svg>
        <p class="text-sm font-medium">Belum ada buku tersedia</p>
    </div>
    @endforelse
</div>

@if($bukus->hasPages())
<div class="mt-5">
    {{ $bukus->links() }}
</div>
@endif

@endsection
