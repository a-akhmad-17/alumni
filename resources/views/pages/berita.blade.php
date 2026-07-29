@extends('layouts.app')

@section('title', 'Kabar & Kegiatan Alumni')
@section('meta_description', 'Kumpulan berita, pengumuman, dan artikel kegiatan terbaru Ikatan Alumni SMAN Kajuara / IKA SMAN 8 Bone.')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="mb-10">
        <span class="text-amber-600 font-semibold text-xs uppercase tracking-wider block mb-2">Informasi Resmi</span>
        <h1 class="font-heading text-3xl sm:text-4xl font-extrabold text-slate-900">Kabar & Berita Alumni</h1>
        <p class="text-slate-600 text-sm mt-2">Dapatkan berita terbaru seputar kegiatan alumni, almamater, dan pengumuman resmi.</p>
    </div>

    <!-- Search & Category Filter Bar -->
    <div class="glass-card rounded-2xl p-4 mb-8 border border-slate-200 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <form action="{{ route('berita.index') }}" method="GET" class="flex gap-2 w-full md:max-w-md">
            @if(request('kategori'))
                <input type="hidden" name="kategori" value="{{ request('kategori') }}">
            @endif
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari berita atau kegiatan..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:border-slate-800">
            <button type="submit" class="px-6 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-sm rounded-xl transition shrink-0">
                <i class="fa-solid fa-search"></i>
            </button>
        </form>

        <!-- Category Filter Tabs -->
        <div class="flex flex-wrap items-center gap-2">
            @php
                $categories = [
                    'semua' => 'Semua',
                    'Berita' => 'Berita',
                    'Kegiatan' => 'Kegiatan',
                    'Pengumuman' => 'Pengumuman',
                    'Opini' => 'Opini',
                ];
                $currentCat = request('kategori', 'semua');
            @endphp
            @foreach($categories as $catKey => $catLabel)
                <a href="{{ route('berita.index', array_merge(request()->except('page', 'kategori'), $catKey !== 'semua' ? ['kategori' => $catKey] : [])) }}"
                   class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition flex items-center {{ $currentCat == $catKey ? 'bg-slate-900 text-white shadow-sm' : 'bg-slate-100 hover:bg-slate-200 text-slate-600' }}">
                   {{ $catLabel }}
                </a>
            @endforeach
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Main Berita Grid -->
        <div class="lg:col-span-8 grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse($beritaList as $berita)
                <article class="glass-card rounded-2xl overflow-hidden flex flex-col group border border-slate-200 hover:border-slate-400 transition">
                    <div class="relative h-48 overflow-hidden">
                        <img src="{{ $berita->gambar }}" alt="{{ $berita->judul }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @php
                            $catColors = [
                                'Berita' => 'bg-sky-500 text-white',
                                'Kegiatan' => 'bg-amber-500 text-white',
                                'Pengumuman' => 'bg-purple-600 text-white',
                                'Opini' => 'bg-emerald-600 text-white',
                            ];
                            $catBadge = $catColors[$berita->kategori ?? 'Berita'] ?? 'bg-slate-800 text-white';
                        @endphp
                        <span class="absolute top-3 right-3 px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider shadow-md backdrop-blur-sm {{ $catBadge }}">
                            {{ $berita->kategori ?? 'Berita' }}
                        </span>
                    </div>
                    <div class="p-6 flex-grow flex flex-col justify-between">
                        <div>
                            <span class="text-[11px] text-amber-600 font-bold uppercase tracking-wider block mb-1">
                                <i class="fa-regular fa-calendar mr-1"></i>{{ \Carbon\Carbon::parse($berita->created_at)->format('d M Y') }}
                            </span>
                            <h3 class="font-heading font-bold text-lg text-slate-900 group-hover:text-amber-600 transition-colors line-clamp-2 mb-2">
                                <a href="{{ route('berita.detail', $berita->slug) }}">{{ $berita->judul }}</a>
                            </h3>
                            <p class="text-xs text-slate-600 line-clamp-3 leading-relaxed">
                                {{ $berita->ringkasan }}
                            </p>
                        </div>
                        <div class="pt-4 mt-4 border-t border-slate-100 flex justify-between items-center text-xs">
                            <span class="text-slate-500"><i class="fa-solid fa-user-pen mr-1"></i>{{ $berita->penulis }}</span>
                            <a href="{{ route('berita.detail', $berita->slug) }}" class="font-bold text-slate-900 hover:text-amber-600">Baca <i class="fa-solid fa-arrow-right ml-1"></i></a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-full py-12 text-center glass-card rounded-2xl text-slate-500">
                    Belum ada berita yang diterbitkan.
                </div>
            @endforelse

            <div class="col-span-full mt-4">
                {{ $beritaList->links() }}
            </div>
        </div>

        <!-- Sidebar Recent Posts -->
        <div class="lg:col-span-4 space-y-6">
            <div class="glass-card rounded-2xl p-6 border border-slate-200">
                <h3 class="font-heading font-bold text-slate-900 text-base mb-4 uppercase tracking-wider text-xs border-b border-slate-100 pb-3">Berita Populer</h3>
                <div class="space-y-4">
                    @foreach($recentPosts as $post)
                        <a href="{{ route('berita.detail', $post->slug) }}" class="flex items-center space-x-3 group">
                            <img src="{{ $post->gambar }}" alt="{{ $post->judul }}" class="w-14 h-14 rounded-xl object-cover shrink-0">
                            <div>
                                <h4 class="font-heading font-semibold text-slate-900 text-xs group-hover:text-amber-600 transition line-clamp-2">{{ $post->judul }}</h4>
                                <span class="text-[10px] text-slate-400 mt-1 block">{{ \Carbon\Carbon::parse($post->created_at)->format('d M Y') }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
