@extends('layouts.app')

@section('title', 'Galeri Foto & Video Dokumentasi')
@section('meta_description', 'Dokumentasi foto kegiatan alumni dan pemutar video dokumentasi resmi Ikatan Keluarga Alumni SMAN Kajuara / IKA SMAN 8 Bone.')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10" x-data="{ mediaFilter: 'semua', kategoriFilter: 'semua', viewMode: 'album', lightboxOpen: false, videoModalOpen: false, activeVideoUrl: '', currentAlbum: [], currentIndex: 0, currentTitle: '', currentDesc: '', currentKat: '' }">
    <!-- Header Banner -->
    <div class="text-center max-w-3xl mx-auto mb-10">
        <span class="px-3.5 py-1 rounded-full bg-amber-100 text-amber-800 border border-amber-200 font-semibold text-xs uppercase tracking-wider inline-block mb-3">
            <i class="fa-solid fa-camera-retro mr-1.5"></i>Dokumentasi Foto & Video
        </span>
        <h1 class="font-heading text-3xl sm:text-5xl font-extrabold text-slate-900 tracking-tight">Galeri Kegiatan Alumni</h1>
        <p class="text-slate-600 text-sm sm:text-base mt-3 leading-relaxed">
            Kumpulan album foto kenangan reuni, video liputan acara, rapat pengurus, bakti sosial, dan momen berharga IKA SMAN Kajuara / SMAN 8 Bone.
        </p>
    </div>

    <!-- Filter Categories & View Mode Toggle -->
    <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-10 border-b border-slate-200 pb-6">
        <!-- Media Filter & Category Buttons -->
        <div class="flex flex-wrap items-center justify-center md:justify-start gap-2">
            <!-- Media Type Filter -->
            <button @click="mediaFilter = 'semua'" :class="mediaFilter === 'semua' ? 'bg-slate-900 text-white shadow-sm font-bold' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200'" class="px-3.5 py-2 rounded-xl text-xs transition">
                Semua Media
            </button>
            <button @click="mediaFilter = 'foto'" :class="mediaFilter === 'foto' ? 'bg-slate-900 text-white shadow-sm font-bold' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200'" class="px-3.5 py-2 rounded-xl text-xs transition flex items-center">
                <i class="fa-solid fa-images mr-1.5 text-amber-400"></i>Album Foto
            </button>
            <button @click="mediaFilter = 'video'" :class="mediaFilter === 'video' ? 'bg-slate-900 text-white shadow-sm font-bold' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200'" class="px-3.5 py-2 rounded-xl text-xs transition flex items-center">
                <i class="fa-solid fa-circle-play mr-1.5 text-rose-500"></i>Video
            </button>

            <!-- Divider -->
            <span class="h-6 w-px bg-slate-300 mx-1 hidden sm:inline-block"></span>

            <!-- Category Filter Dropdown -->
            <select x-model="kategoriFilter" class="px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs font-bold text-slate-800 focus:outline-none focus:border-slate-900 cursor-pointer shadow-sm">
                <option value="semua">Semua Kategori</option>
                @foreach($kategoriList as $kat)
                    <option value="{{ $kat }}">{{ $kat }}</option>
                @endforeach
            </select>
        </div>

        <!-- View Mode Toggle -->
        <div class="flex items-center space-x-1 bg-slate-100 p-1 rounded-xl border border-slate-200 shrink-0">
            <button @click="viewMode = 'album'" :class="viewMode === 'album' ? 'bg-white text-slate-900 shadow-sm font-bold' : 'text-slate-600 hover:text-slate-900 font-semibold'" class="px-3 py-1.5 rounded-lg text-xs transition flex items-center">
                <i class="fa-solid fa-folder-open mr-1.5 text-amber-500"></i>Album Kegiatan
            </button>
            <button @click="viewMode = 'grid'" :class="viewMode === 'grid' ? 'bg-white text-slate-900 shadow-sm font-bold' : 'text-slate-600 hover:text-slate-900 font-semibold'" class="px-3 py-1.5 rounded-lg text-xs transition flex items-center">
                <i class="fa-solid fa-table-cells mr-1.5 text-sky-500"></i>Semua Pratinjau
            </button>
        </div>
    </div>

    <!-- 📁 MODE 1: ALBUM KEGIATAN (MULTI-FOTO & VIDEO PER KEGIATAN) -->
    <div x-show="viewMode === 'album'" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($kegiatanGrouped as $judulKegiatan => $items)
            @php
                $coverPhoto = $items->firstWhere('is_cover', 1) ?? $items->first();
                $totalFoto = $items->where('tipe', 'foto')->count();
                $hasVideo = $items->where('tipe', 'video')->first();
                $isMediaMatch = true;
            @endphp
            <div x-show="(mediaFilter === 'semua' || (mediaFilter === 'foto' && {{ $totalFoto > 0 ? 'true' : 'false' }}) || (mediaFilter === 'video' && {{ $hasVideo ? 'true' : 'false' }})) && (kategoriFilter === 'semua' || '{{ $coverPhoto->kategori }}' === kategoriFilter)" class="glass-card rounded-3xl overflow-hidden cursor-pointer group border border-slate-200 hover:border-amber-400 transition duration-300 bg-white flex flex-col justify-between shadow-md hover:shadow-xl">
                
                <!-- Media Header / Cover Photo -->
                <div class="h-64 relative bg-slate-900 overflow-hidden" @click="
                    if({{ $hasVideo ? 'true' : 'false' }} && ({{ $totalFoto == 0 ? 'true' : 'false' }} || '{{ $coverPhoto->tipe }}' === 'video' || mediaFilter === 'video')) {
                        activeVideoUrl = getEmbedUrl('{{ $hasVideo->video_url ?? '' }}');
                        currentTitle = @js($judulKegiatan);
                        currentDesc = @js($hasVideo->deskripsi ?? '');
                        videoModalOpen = true;
                    } else {
                        currentTitle = @js($judulKegiatan);
                        currentAlbum = @js($items->values());
                        currentIndex = 0;
                        currentDesc = @js($coverPhoto->deskripsi ?? '');
                        currentKat = @js($coverPhoto->kategori ?? 'Kegiatan');
                        lightboxOpen = true;
                    }
                ">
                    @if($coverPhoto->gambar)
                        <img src="{{ str_starts_with($coverPhoto->gambar, 'http') ? $coverPhoto->gambar : asset($coverPhoto->gambar) }}" alt="{{ $judulKegiatan }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    @else
                        <div class="w-full h-full bg-slate-900 flex flex-col items-center justify-center text-white">
                            <i class="fa-solid fa-film text-4xl text-rose-500 mb-2"></i>
                            <span class="text-xs font-bold text-slate-300">Video Dokumentasi</span>
                        </div>
                    @endif
                    
                    <!-- Multi-Photo or Video Count Badge -->
                    <div class="absolute top-3 right-3 flex items-center space-x-2">
                        @if($totalFoto > 0)
                            <span class="px-3 py-1 rounded-full bg-slate-900/90 backdrop-blur-md text-amber-400 text-xs font-black border border-amber-400/30 shadow-md flex items-center">
                                <i class="fa-solid fa-images mr-1.5"></i>{{ $totalFoto }} Foto
                            </span>
                        @endif
                        @if($hasVideo)
                            <span class="px-3 py-1 rounded-full bg-rose-600 text-white text-xs font-black shadow-md flex items-center animate-pulse">
                                <i class="fa-solid fa-circle-play mr-1"></i>Video
                            </span>
                        @endif
                    </div>

                    <!-- Category Badge -->
                    <div class="absolute top-3 left-3 px-3 py-1 rounded-full bg-slate-900/80 backdrop-blur-md text-white text-[10px] font-extrabold uppercase tracking-wider border border-white/20">
                        {{ $coverPhoto->kategori }}
                    </div>

                    <!-- Play Icon Overlay if Video -->
                    @if($hasVideo)
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-16 h-16 rounded-full bg-rose-600/90 hover:bg-rose-600 text-white flex items-center justify-center shadow-2xl group-hover:scale-110 transition duration-300 border-2 border-white">
                                <i class="fa-solid fa-play text-2xl ml-1"></i>
                            </div>
                        </div>
                    @endif

                    <!-- Gradient Overlay for Hover preview -->
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/40 to-transparent opacity-60 group-hover:opacity-80 transition duration-300 flex items-end p-5">
                        <div class="text-white">
                            <span class="text-[10px] text-amber-400 font-bold uppercase tracking-wider block mb-1">
                                <i class="fa-solid {{ $hasVideo && ($totalFoto == 0 || $coverPhoto->tipe === 'video') ? 'fa-circle-play' : 'fa-eye' }} mr-1"></i>
                                {{ $hasVideo && ($totalFoto == 0 || $coverPhoto->tipe === 'video') ? 'Klik Untuk Memutar Video' : 'Klik Untuk Buka Gallery Slider' }}
                            </span>
                            <h3 class="font-heading font-extrabold text-white text-lg leading-snug line-clamp-2">{{ $judulKegiatan }}</h3>
                        </div>
                    </div>
                </div>

                <!-- Footer Body & Thumbnail Strip Preview -->
                <div class="p-5 bg-white">
                    <p class="text-xs text-slate-600 line-clamp-2 leading-relaxed mb-4 font-normal">
                        {{ $coverPhoto->deskripsi ?? 'Dokumentasi foto dan video kegiatan resmi IKA SMAN Kajuara / SMAN 8 Bone.' }}
                    </p>

                    <!-- Mini Thumbnails Strip -->
                    @if($items->count() > 1)
                        <div class="pt-3 border-t border-slate-100 flex items-center space-x-2 overflow-x-auto">
                            <span class="text-[10px] font-bold uppercase text-slate-400 shrink-0">Pratinjau:</span>
                            @foreach($items->take(4) as $idx => $pThumb)
                                <div class="w-9 h-9 rounded-lg overflow-hidden border border-slate-200 shrink-0 bg-slate-900 relative">
                                    @if($pThumb->gambar)
                                        <img src="{{ str_starts_with($pThumb->gambar, 'http') ? $pThumb->gambar : asset($pThumb->gambar) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-rose-500 text-xs bg-slate-900">
                                            <i class="fa-solid fa-play"></i>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 text-center glass-card rounded-3xl text-slate-500 bg-white border border-slate-200">
                Belum ada album foto atau video untuk kategori ini.
            </div>
        @endforelse
    </div>

    <!-- 🖼️ MODE 2: SEMUA PRATINJAU GRID -->
    <div x-show="viewMode === 'grid'" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @forelse($galeriList as $foto)
            <div x-show="(mediaFilter === 'semua' || mediaFilter === '{{ $foto->tipe }}') && (kategoriFilter === 'semua' || '{{ $foto->kategori }}' === kategoriFilter)" @click="
                if('{{ $foto->tipe }}' === 'video') {
                    activeVideoUrl = getEmbedUrl('{{ $foto->video_url }}');
                    currentTitle = '{{ e($foto->judul) }}';
                    currentDesc = '{{ e($foto->deskripsi) }}';
                    videoModalOpen = true;
                } else {
                    currentTitle = @js($foto->judul);
                    currentAlbum = [@js($foto)];
                    currentIndex = 0;
                    currentDesc = @js($foto->deskripsi ?? '');
                    currentKat = @js($foto->kategori);
                    lightboxOpen = true;
                }
            " class="glass-card rounded-2xl overflow-hidden cursor-pointer group border border-slate-200 hover:border-amber-400 transition duration-300 relative h-64 shadow-md bg-slate-900">
                @if($foto->gambar)
                    <img src="{{ str_starts_with($foto->gambar, 'http') ? $foto->gambar : asset($foto->gambar) }}" alt="{{ $foto->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                @else
                    <div class="w-full h-full bg-slate-900 flex items-center justify-center text-rose-500 text-4xl">
                        <i class="fa-solid fa-circle-play"></i>
                    </div>
                @endif
                
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-5 text-white">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-amber-400 bg-slate-900/80 px-2 py-0.5 rounded-full inline-block w-max mb-1 border border-amber-400/30">
                        {{ $foto->kategori }}
                    </span>
                    <h3 class="font-heading font-bold text-white text-base line-clamp-1">{{ $foto->judul }}</h3>
                    <p class="text-xs text-slate-300 line-clamp-2 mt-1">{{ $foto->deskripsi }}</p>
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 text-center glass-card rounded-2xl text-slate-500 bg-white border border-slate-200">
                Belum ada foto atau video galeri.
            </div>
        @endforelse
    </div>

    <!-- 🔍 MULTI-PHOTO INTERACTIVE LIGHTBOX CAROUSEL SLIDER MODAL -->
    <div x-show="lightboxOpen" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/85 backdrop-blur-md p-4" style="display: none;" @keydown.window.escape="lightboxOpen = false" @keydown.window.left="currentIndex = (currentIndex - 1 + currentAlbum.length) % currentAlbum.length" @keydown.window.right="currentIndex = (currentIndex + 1) % currentAlbum.length">
        <div @click.away="lightboxOpen = false" class="max-w-5xl w-full bg-slate-900 rounded-3xl overflow-hidden border border-slate-800 relative shadow-2xl flex flex-col max-h-[92vh]">
            
            <!-- Modal Header Bar -->
            <div class="p-4 bg-slate-950/90 border-b border-slate-800 flex items-center justify-between shrink-0 text-white z-20">
                <div class="flex items-center space-x-3">
                    <span class="px-3 py-1 rounded-full bg-amber-500 text-slate-950 text-[10px] font-black uppercase tracking-wider" x-text="currentKat"></span>
                    <h3 class="font-heading font-bold text-base text-white truncate max-w-md sm:max-w-xl" x-text="currentTitle"></h3>
                </div>
                <div class="flex items-center space-x-3">
                    <template x-if="currentAlbum.length > 1">
                        <span class="px-3 py-1 rounded-full bg-slate-800 text-amber-400 text-xs font-bold border border-slate-700">
                            Foto <span x-text="currentIndex + 1"></span> dari <span x-text="currentAlbum.length"></span>
                        </span>
                    </template>
                    <button @click="lightboxOpen = false" class="w-9 h-9 rounded-full bg-slate-800 hover:bg-rose-600 text-white flex items-center justify-center transition border border-slate-700">
                        <i class="fa-solid fa-xmark text-base"></i>
                    </button>
                </div>
            </div>

            <!-- Main Slide Photo / Video Viewer -->
            <div class="relative flex-grow min-h-[50vh] max-h-[68vh] bg-slate-950 flex items-center justify-center overflow-hidden">
                <template x-if="currentAlbum.length > 0 && currentAlbum[currentIndex].gambar">
                    <img :src="currentAlbum[currentIndex].gambar" :alt="currentTitle" class="max-h-[68vh] w-auto max-w-full object-contain select-none transition-all duration-300">
                </template>

                <!-- Prev & Next Arrow Buttons -->
                <template x-if="currentAlbum.length > 1">
                    <div>
                        <button @click="currentIndex = (currentIndex - 1 + currentAlbum.length) % currentAlbum.length" class="absolute left-4 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-slate-900/80 hover:bg-amber-500 text-white hover:text-slate-950 flex items-center justify-center transition duration-200 border border-slate-700 shadow-xl z-20">
                            <i class="fa-solid fa-chevron-left text-lg"></i>
                        </button>
                        <button @click="currentIndex = (currentIndex + 1) % currentAlbum.length" class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-slate-900/80 hover:bg-amber-500 text-white hover:text-slate-950 flex items-center justify-center transition duration-200 border border-slate-700 shadow-xl z-20">
                            <i class="fa-solid fa-chevron-right text-lg"></i>
                        </button>
                    </div>
                </template>
            </div>

            <!-- Modal Footer Description & Thumbnail Strip Slider -->
            <div class="p-5 bg-slate-950 border-t border-slate-800 shrink-0 text-white space-y-3">
                <template x-if="currentAlbum.length > 0">
                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed max-w-3xl" x-text="currentAlbum[currentIndex].deskripsi || currentDesc || 'Dokumentasi foto kegiatan resmi IKA SMAN Kajuara / SMAN 8 Bone.'"></p>
                </template>

                <!-- Thumbnail Navigation Strip -->
                <template x-if="currentAlbum.length > 1">
                    <div class="flex items-center space-x-2 overflow-x-auto pt-2 border-t border-slate-800/80 pb-1">
                        <template x-for="(fotoItem, idx) in currentAlbum" :key="idx">
                            <button @click="currentIndex = idx" :class="currentIndex === idx ? 'border-2 border-amber-400 scale-105 shadow-md' : 'border border-slate-700 opacity-60 hover:opacity-100'" class="w-12 h-12 rounded-xl overflow-hidden shrink-0 transition duration-200 bg-slate-900">
                                <img :src="fotoItem.gambar" class="w-full h-full object-cover">
                            </button>
                        </template>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <!-- 🎥 VIDEO PLAYER MODAL -->
    <div x-show="videoModalOpen" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/90 backdrop-blur-md p-4" style="display: none;">
        <div @click.away="videoModalOpen = false" class="max-w-4xl w-full bg-slate-900 rounded-3xl overflow-hidden border border-slate-800 relative shadow-2xl flex flex-col">
            <div class="p-4 bg-slate-950 border-b border-slate-800 flex items-center justify-between text-white">
                <h3 class="font-heading font-bold text-base text-white truncate" x-text="currentTitle"></h3>
                <button @click="videoModalOpen = false; activeVideoUrl = ''" class="w-8 h-8 rounded-full bg-slate-800 text-white flex items-center justify-center hover:bg-rose-600 transition">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="aspect-video w-full bg-black">
                <iframe :src="activeVideoUrl" class="w-full h-full border-0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
            <div class="p-4 bg-slate-950 text-xs text-slate-300">
                <p x-text="currentDesc"></p>
            </div>
        </div>
    </div>
</div>

<script>
    function getEmbedUrl(url) {
        if(!url) return '';
        if(url.includes('youtu.be/')) {
            let id = url.split('youtu.be/')[1].split('?')[0];
            return 'https://www.youtube.com/embed/' + id + '?autoplay=1';
        } else if(url.includes('youtube.com/watch?v=')) {
            let id = url.split('v=')[1].split('&')[0];
            return 'https://www.youtube.com/embed/' + id + '?autoplay=1';
        } else if(url.includes('youtube.com/embed/')) {
            return url + '?autoplay=1';
        }
        return url;
    }
</script>
@endsection
