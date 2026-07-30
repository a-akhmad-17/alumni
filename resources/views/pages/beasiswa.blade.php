@extends('layouts.app')

@section('title', 'Informasi Beasiswa - IKA SMAN Kajuara / SMAN 8 Bone')
@section('meta_description', 'Portal Informasi Beasiswa Resmi IKA SMAN Kajuara / SMAN 8 Bone. Dapatkan informasi beasiswa pendidikan, kemitraan, dan link pendaftaran resmi.')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <!-- Header Banner Section -->
    <div class="mb-10 text-center max-w-3xl mx-auto">
        <span class="px-3.5 py-1 rounded-full bg-amber-100 text-amber-900 border border-amber-300 text-xs font-black uppercase tracking-wider inline-block mb-3">
            <i class="fa-solid fa-graduation-cap mr-1.5 text-amber-600"></i>Program Beasiswa & Edukasi
        </span>
        <h1 class="font-heading text-3xl sm:text-4xl font-extrabold text-slate-900 leading-tight">
            Informasi Beasiswa IKA SMAN Kajuara
        </h1>
        <p class="text-slate-600 text-sm sm:text-base mt-2">
            Peluang beasiswa pendidikan dan program bantuan bagi alumni & siswa SMAN Kajuara / SMAN 8 Bone.
        </p>
    </div>

    <!-- Search Form -->
    <div class="max-w-2xl mx-auto mb-10">
        <form action="{{ route('beasiswa.index') }}" method="GET">
            <div class="relative flex items-center">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-slate-400">
                    <i class="fa-solid fa-search text-base"></i>
                </span>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama beasiswa atau informasi..." class="w-full pl-11 pr-28 py-3.5 bg-white border border-slate-300 rounded-2xl text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:border-slate-900 shadow-sm transition">
                <button type="submit" class="absolute right-2 px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-xl shadow transition">
                    Cari
                </button>
            </div>
        </form>
    </div>

    <!-- WIDE BANNER CARD LIST -->
    <div class="space-y-8">
        @forelse($beasiswaList as $beasiswa)
            <div class="glass-card rounded-3xl bg-white border border-slate-200 shadow-md overflow-hidden hover:border-slate-400 transition duration-300">
                
                <!-- Wide Banner Image -->
                @if($beasiswa->gambar)
                    <div class="w-full h-52 sm:h-72 bg-slate-950 overflow-hidden relative group">
                        <img src="{{ asset($beasiswa->gambar) }}" alt="{{ $beasiswa->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent"></div>
                        <span class="absolute top-4 right-4 px-3 py-1 rounded-full bg-emerald-500 text-white text-xs font-extrabold uppercase tracking-wider shadow-md">
                            <i class="fa-solid fa-circle-check mr-1"></i>DIBUKA
                        </span>
                    </div>
                @endif

                <!-- Content Body -->
                <div class="p-6 sm:p-8">
                    <div class="flex items-start justify-between gap-4 mb-3">
                        <h2 class="font-heading font-extrabold text-2xl sm:text-3xl text-slate-900 leading-snug">
                            {{ $beasiswa->judul }}
                        </h2>
                    </div>

                    <!-- Informasi Description -->
                    <div class="prose max-w-none text-slate-600 text-sm sm:text-base leading-relaxed mb-6">
                        {!! nl2br(e($beasiswa->informasi)) !!}
                    </div>

                    <!-- Action Link Button -->
                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between flex-wrap gap-4">
                        <span class="text-xs text-slate-400">
                            <i class="fa-solid fa-clock mr-1"></i>Diterbitkan: {{ $beasiswa->created_at->translatedFormat('d F Y') }}
                        </span>

                        <a href="{{ $beasiswa->link_eksternal }}" target="_blank" rel="noopener noreferrer" 
                           class="px-6 py-3.5 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-slate-950 font-extrabold text-xs sm:text-sm uppercase tracking-wider rounded-2xl shadow-lg transition flex items-center shrink-0">
                            <span>Kunjungi Link Beasiswa</span>
                            <i class="fa-solid fa-arrow-up-right-from-square ml-2 text-slate-950"></i>
                        </a>
                    </div>
                </div>

            </div>
        @empty
            <div class="py-16 text-center glass-card rounded-3xl bg-white border border-slate-200">
                <i class="fa-solid fa-graduation-cap text-5xl text-slate-300 mb-3 block"></i>
                <h3 class="font-heading font-bold text-slate-900 text-xl">Belum Ada Informasi Beasiswa</h3>
                <p class="text-slate-500 text-sm mt-1">Saat ini belum ada informasi beasiswa terbaru yang dipublikasikan.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-10">
        {{ $beasiswaList->links() }}
    </div>

</div>
@endsection
