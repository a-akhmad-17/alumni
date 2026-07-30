@extends('layouts.app')

@section('title', 'Infografis & Announcement Flyer - IKA SMAN Kajuara / SMAN 8 Bone')
@section('meta_description', 'Galeri Infografis & Announcement Flyer Resmi IKA SMAN Kajuara / SMAN 8 Bone. Dapatkan informasi visual seputar kegiatan, beasiswa, dan pengumuman alumni.')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10" x-data="{ lightboxOpen: false, activeFlyer: {} }">

    <!-- Header Section -->
    <div class="mb-10 text-center max-w-3xl mx-auto">
        <span class="px-3.5 py-1 rounded-full bg-rose-100 text-rose-900 border border-rose-300 text-xs font-black uppercase tracking-wider inline-block mb-3">
            <i class="fa-solid fa-bullhorn mr-1.5 text-rose-600"></i>Pusat Informasi Visual
        </span>
        <h1 class="font-heading text-3xl sm:text-4xl font-extrabold text-slate-900 leading-tight">
            Infografis & Announcement Flyer
        </h1>
        <p class="text-slate-600 text-sm sm:text-base mt-2">
            Kumpulan flyer pengumuman resmi, infografis kegiatan, dan publikasi visual alumni IKA SMAN Kajuara / SMAN 8 Bone.
        </p>
    </div>

    <!-- Search Form -->
    <div class="max-w-xl mx-auto mb-10">
        <form action="{{ route('infografis.index') }}" method="GET">
            <div class="relative flex items-center">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-slate-400">
                    <i class="fa-solid fa-search text-sm"></i>
                </span>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari infografis / flyer..." class="w-full pl-11 pr-28 py-3 bg-white border border-slate-300 rounded-2xl text-xs sm:text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:border-slate-900 shadow-sm transition">
                <button type="submit" class="absolute right-2 px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-xl shadow transition">
                    Cari
                </button>
            </div>
        </form>
    </div>

    <!-- INFOGRAFIS GRID -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($infografisList as $item)
            <div class="glass-card rounded-3xl bg-white border border-slate-200 shadow-sm overflow-hidden group hover:border-slate-400 transition duration-300 flex flex-col justify-between">
                <div>
                    <!-- Image Card with Zoom Click -->
                    <div class="w-full aspect-[4/5] bg-slate-950 overflow-hidden relative cursor-pointer" @click="lightboxOpen = true; activeFlyer = @js($item)">
                        <img src="{{ asset($item->gambar) }}" alt="{{ $item->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-slate-950/30 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <span class="px-4 py-2 bg-white/90 backdrop-blur-md rounded-full text-slate-900 font-bold text-xs shadow-lg">
                                <i class="fa-solid fa-expand mr-1.5 text-amber-500"></i>Perbesar Flyer
                            </span>
                        </div>
                        @if($item->is_popup)
                            <span class="absolute top-3 left-3 px-2.5 py-0.5 rounded-full bg-amber-500 text-slate-950 text-[10px] font-black uppercase tracking-wider shadow">
                                Announcement
                            </span>
                        @endif
                    </div>

                    <!-- Content -->
                    <div class="p-5">
                        <h3 class="font-heading font-extrabold text-lg text-slate-900 leading-snug group-hover:text-amber-600 transition-colors mb-2">
                            {{ $item->judul }}
                        </h3>
                        @if($item->deskripsi)
                            <p class="text-xs text-slate-600 line-clamp-3 leading-relaxed">
                                {{ $item->deskripsi }}
                            </p>
                        @endif
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="px-5 pb-5 pt-2 flex items-center justify-between border-t border-slate-100">
                    <span class="text-[11px] text-slate-400">
                        <i class="fa-solid fa-calendar-day mr-1"></i>{{ $item->created_at->translatedFormat('d M Y') }}
                    </span>

                    <div class="flex items-center space-x-2">
                        <button @click="lightboxOpen = true; activeFlyer = @js($item)" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs rounded-xl transition">
                            <i class="fa-solid fa-eye mr-1"></i>Lihat
                        </button>
                        @if($item->link_tautan)
                            <a href="{{ $item->link_tautan }}" target="_blank" class="px-3 py-1.5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-xl shadow transition">
                                <i class="fa-solid fa-link mr-1 text-amber-400"></i>Tautan
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 text-center glass-card rounded-3xl bg-white border border-slate-200">
                <i class="fa-solid fa-bullhorn text-5xl text-slate-300 mb-3 block"></i>
                <h3 class="font-heading font-bold text-slate-900 text-xl">Belum Ada Infografis / Flyer</h3>
                <p class="text-slate-500 text-sm mt-1">Saat ini belum ada pengumuman infografis yang dipublikasikan.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-10">
        {{ $infografisList->links() }}
    </div>

    <!-- LIGHTBOX IMAGE MODAL -->
    <div x-show="lightboxOpen" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/90 backdrop-blur-md p-4" style="display: none;">
        <div @click.away="lightboxOpen = false" class="bg-white rounded-3xl p-4 sm:p-6 max-w-2xl w-full border border-slate-200 shadow-2xl relative max-h-[90vh] flex flex-col">
            <button @click="lightboxOpen = false" class="absolute top-4 right-4 w-9 h-9 rounded-full bg-slate-900 text-white hover:bg-slate-800 flex items-center justify-center z-10 shadow-lg">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>

            <div class="overflow-y-auto pr-1">
                <div class="w-full bg-slate-950 rounded-2xl overflow-hidden mb-4 border border-slate-200">
                    <img :src="'{{ url('/') }}/' + activeFlyer.gambar" :alt="activeFlyer.judul" class="w-full h-auto max-h-[60vh] object-contain mx-auto">
                </div>

                <h3 class="font-heading font-extrabold text-xl text-slate-900 mb-2" x-text="activeFlyer.judul"></h3>
                <p class="text-xs text-slate-600 leading-relaxed mb-4" x-text="activeFlyer.deskripsi || ''"></p>

                <div class="flex items-center justify-between border-t border-slate-100 pt-3">
                    <template x-if="activeFlyer.link_tautan">
                        <a :href="activeFlyer.link_tautan" target="_blank" class="px-5 py-2.5 bg-amber-500 hover:bg-amber-600 text-slate-950 font-extrabold text-xs uppercase tracking-wider rounded-xl shadow transition flex items-center">
                            <i class="fa-solid fa-arrow-up-right-from-square mr-2"></i>Buka Link Terkait
                        </a>
                    </template>
                    <button @click="lightboxOpen = false" class="px-5 py-2.5 bg-slate-900 text-white font-bold text-xs rounded-xl ml-auto">Tutup</button>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
