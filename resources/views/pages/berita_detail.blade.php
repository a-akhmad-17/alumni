@extends('layouts.app')

@section('title', $berita->judul)
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags($berita->ringkasan ?? $berita->isi), 160))
@section('meta_image', asset($berita->gambar))
@section('og_type', 'article')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Article Header -->
    <div class="mb-8">
        <a href="{{ route('berita.index') }}" class="inline-flex items-center text-xs font-bold text-slate-800 hover:text-amber-600 mb-4 transition">
            <i class="fa-solid fa-arrow-left mr-2"></i>Kembali ke Berita
        </a>
        <div class="flex items-center space-x-3 text-xs text-slate-500 mb-3">
            @if(isset($berita->kategori))
                <span class="px-3 py-1 rounded-full bg-amber-500 text-slate-900 font-extrabold text-[10px] uppercase tracking-wider">{{ $berita->kategori }}</span>
            @endif
            <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-800 font-bold border border-slate-200"><i class="fa-solid fa-user-pen mr-1"></i>{{ $berita->penulis }}</span>
            <span><i class="fa-regular fa-calendar mr-1"></i>{{ \Carbon\Carbon::parse($berita->created_at)->format('d F Y') }}</span>
        </div>
        <h1 class="font-heading text-2xl sm:text-4xl font-extrabold text-slate-900 leading-tight mb-4">{{ $berita->judul }}</h1>

        <!-- Top Share Bar -->
        <div x-data="{ copied: false }" class="flex flex-wrap items-center gap-2 pt-2 border-t border-slate-200/80">
            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider mr-1"><i class="fa-solid fa-share-nodes mr-1 text-amber-500"></i>Bagikan:</span>
            
            <a href="https://api.whatsapp.com/send?text={{ rawurlencode($berita->judul . ' - ' . url()->current()) }}" target="_blank" rel="noopener noreferrer" class="px-3 py-1.5 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white font-bold text-xs transition flex items-center shadow-sm">
                <i class="fa-brands fa-whatsapp mr-1.5 text-sm"></i>WhatsApp
            </a>

            <a href="https://www.facebook.com/sharer/sharer.php?u={{ rawurlencode(url()->current()) }}" target="_blank" rel="noopener noreferrer" class="px-3 py-1.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs transition flex items-center shadow-sm">
                <i class="fa-brands fa-facebook-f mr-1.5 text-sm"></i>Facebook
            </a>

            <button @click="navigator.clipboard.writeText('{{ url()->current() }}'); copied = true; setTimeout(() => copied = false, 3000)" class="px-3 py-1.5 rounded-xl bg-gradient-to-r from-purple-600 via-pink-500 to-amber-500 hover:opacity-90 text-white font-bold text-xs transition flex items-center shadow-sm">
                <i class="fa-brands fa-instagram mr-1.5 text-sm"></i>
                <span x-text="copied ? 'Tautan Disalin!' : 'Instagram / Salin'"></span>
            </button>

            <a href="https://t.me/share/url?url={{ rawurlencode(url()->current()) }}&text={{ rawurlencode($berita->judul) }}" target="_blank" rel="noopener noreferrer" class="px-3 py-1.5 rounded-xl bg-sky-500 hover:bg-sky-600 text-white font-bold text-xs transition flex items-center shadow-sm">
                <i class="fa-brands fa-telegram mr-1.5 text-sm"></i>Telegram
            </a>
        </div>
    </div>

    <!-- Article Image Banner -->
    <div class="rounded-3xl overflow-hidden mb-10 h-72 sm:h-96 shadow-lg border border-slate-200">
        <img src="{{ str_starts_with($berita->gambar, 'http') ? $berita->gambar : asset($berita->gambar) }}" alt="{{ $berita->judul }}" class="w-full h-full object-cover">
    </div>

    <!-- Article Content -->
    <div class="glass-card rounded-3xl p-6 sm:p-10 border border-slate-200 text-slate-700 leading-relaxed text-base space-y-6">
        @if(!empty($berita->ringkasan))
            <p class="font-semibold text-lg text-slate-900 border-l-4 border-slate-900 pl-4 py-1 italic bg-slate-50 rounded-r-xl">
                {{ $berita->ringkasan }}
            </p>
        @endif

        <div class="prose max-w-none text-slate-700 leading-relaxed space-y-4">
            {!! $berita->isi !!}
        </div>

        <!-- Bottom Share Box -->
        <div x-data="{ copiedBottom: false }" class="pt-8 border-t border-slate-200 mt-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center space-x-2">
                <i class="fa-solid fa-heart text-rose-500"></i>
                <span class="font-bold text-xs text-slate-700">Sukai & Bagikan Berita Ini ke Rekan Alumni</span>
            </div>

            <div class="flex items-center flex-wrap gap-2">
                <a href="https://api.whatsapp.com/send?text={{ rawurlencode($berita->judul . ' - ' . url()->current()) }}" target="_blank" rel="noopener noreferrer" class="px-3 py-1.5 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white font-bold text-xs transition flex items-center">
                    <i class="fa-brands fa-whatsapp mr-1.5 text-sm"></i>WhatsApp
                </a>

                <a href="https://www.facebook.com/sharer/sharer.php?u={{ rawurlencode(url()->current()) }}" target="_blank" rel="noopener noreferrer" class="px-3 py-1.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs transition flex items-center">
                    <i class="fa-brands fa-facebook-f mr-1.5 text-sm"></i>Facebook
                </a>

                <button @click="navigator.clipboard.writeText('{{ url()->current() }}'); copiedBottom = true; setTimeout(() => copiedBottom = false, 3000)" class="px-3 py-1.5 rounded-xl bg-gradient-to-r from-purple-600 via-pink-500 to-amber-500 hover:opacity-90 text-white font-bold text-xs transition flex items-center">
                    <i class="fa-brands fa-instagram mr-1.5 text-sm"></i>
                    <span x-text="copiedBottom ? 'Tautan Disalin!' : 'Instagram / Salin'"></span>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
