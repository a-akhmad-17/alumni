@extends('layouts.app')

@section('title', 'Verifikasi Keaslian KTA Digital - IKA SMAN Kajuara')
@section('meta_description', 'Halaman Resmi Verifikasi Keaslian Kartu Tanda Anggota (KTA) Digital IKA SMAN Kajuara / SMAN 8 Bone.')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    <!-- Card Container -->
    <div class="glass-card rounded-3xl p-6 sm:p-10 bg-white border border-slate-200 shadow-xl text-center relative overflow-hidden">
        
        @if($isValid && $alumni)
            <!-- Top Verification Status Seal -->
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-emerald-100 text-emerald-600 border-4 border-emerald-500/30 mb-4 shadow-lg">
                <i class="fa-solid fa-shield-check text-4xl"></i>
            </div>

            <div class="inline-block px-4 py-1.5 rounded-full bg-emerald-50 text-emerald-800 border border-emerald-300 text-xs font-black uppercase tracking-wider mb-2">
                ✓ KARTU TERVERIFIKASI RESMI
            </div>

            <h1 class="font-heading text-2xl sm:text-3xl font-extrabold text-slate-900 mb-2">
                Kartu Tanda Anggota (KTA) Valid
            </h1>
            <p class="text-slate-600 text-sm max-w-lg mx-auto mb-8">
                Data anggota di bawah ini terdaftar dan diverifikasi secara sah dalam database **Ikatan Alumni SMAN Kajuara / SMAN 8 Bone**.
            </p>

            <!-- Detailed Profile Card -->
            <div class="bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950 rounded-3xl p-6 text-white text-left shadow-2xl border-2 border-amber-500/40 relative overflow-hidden mb-8">
                <div class="absolute -top-10 -right-10 w-36 h-36 bg-amber-500/10 rounded-full blur-xl pointer-events-none"></div>

                <div class="flex items-center justify-between border-b border-amber-500/30 pb-4 mb-5">
                    <div class="flex items-center space-x-3">
                        <img src="{{ asset('assets/images/logo.webp') }}" alt="Logo IKA" class="h-10 w-auto object-contain">
                        <div>
                            <span class="font-heading font-extrabold text-xs text-amber-400 block tracking-tight">IKA SMAN KAJUARA / SMAN 8 BONE</span>
                            <span class="text-[9px] text-slate-300 tracking-wider uppercase block">Sistem Verifikasi Keaslian KTA</span>
                        </div>
                    </div>
                    <span class="px-2.5 py-1 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-400/30 text-[10px] font-extrabold uppercase">
                        ACTIVE MEMBER
                    </span>
                </div>

                <div class="grid grid-cols-12 gap-4 items-center">
                    <div class="col-span-4 sm:col-span-3">
                        <div class="w-20 h-24 sm:w-24 sm:h-28 rounded-2xl p-0.5 bg-gradient-to-b from-amber-400 to-amber-600 shadow-xl overflow-hidden">
                            @if($alumni->foto)
                                <img src="{{ asset($alumni->foto) }}" alt="{{ $alumni->nama }}" class="w-full h-full object-cover rounded-[14px]">
                            @else
                                <div class="w-full h-full bg-slate-900 rounded-[14px] flex items-center justify-center text-amber-400 font-heading font-extrabold text-xl">
                                    {{ substr($alumni->nama, 0, 2) }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="col-span-8 sm:col-span-9 space-y-2">
                        <div>
                            <span class="text-[10px] uppercase text-slate-400 tracking-wider">Nama Lengkap</span>
                            <h2 class="font-heading font-bold text-lg sm:text-xl text-white">{{ $alumni->nama }}</h2>
                        </div>

                        <div class="grid grid-cols-2 gap-2 text-xs">
                            <div>
                                <span class="text-[10px] uppercase text-slate-400 tracking-wider">Angkatan</span>
                                <p class="font-semibold text-amber-300">Angkatan {{ $alumni->angkatan }}</p>
                            </div>
                            <div>
                                <span class="text-[10px] uppercase text-slate-400 tracking-wider">Nomor KTA</span>
                                <p class="font-mono font-bold text-amber-400">{{ $ktaNumber }}</p>
                            </div>
                            <div>
                                <span class="text-[10px] uppercase text-slate-400 tracking-wider">Profesi</span>
                                <p class="font-semibold text-slate-200 truncate">{{ $alumni->profesi ?? 'Alumni' }}</p>
                            </div>
                            <div>
                                <span class="text-[10px] uppercase text-slate-400 tracking-wider">Domisili</span>
                                <p class="font-semibold text-slate-200 truncate">{{ $alumni->domisili ?? 'Indonesia' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Verification Metadata -->
            <div class="bg-slate-50 rounded-2xl p-4 border border-slate-200 text-xs text-slate-600 text-left space-y-1 mb-8">
                <div class="flex justify-between">
                    <span class="text-slate-500">Status Verifikasi Sistem:</span>
                    <span class="font-bold text-emerald-700">Telah Diverifikasi & Sah (Approved)</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Waktu Pengecekan Scan:</span>
                    <span class="font-mono text-slate-800">{{ now()->translatedFormat('d F Y, H:i:s') }} WITA</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Penerbit:</span>
                    <span class="font-semibold text-slate-900">Pengurus Pusat IKA SMAN Kajuara / SMAN 8 Bone</span>
                </div>
            </div>

            <div class="flex items-center justify-center space-x-3">
                <a href="{{ route('kta.index', ['id' => $alumni->id]) }}" class="px-6 py-3 bg-amber-500 hover:bg-amber-600 text-slate-950 font-extrabold text-xs uppercase tracking-wider rounded-2xl shadow-lg transition flex items-center">
                    <i class="fa-solid fa-id-card mr-2"></i>Buka KTA Digital
                </a>
                <a href="{{ route('alumni.index') }}" class="px-5 py-3 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs uppercase tracking-wider rounded-2xl transition flex items-center">
                    <i class="fa-solid fa-users mr-2 text-amber-400"></i>Lihat Direktori
                </a>
            </div>

        @else
            <!-- Unverified / Invalid Warning Card -->
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-rose-100 text-rose-600 border-4 border-rose-500/30 mb-4 shadow-lg">
                <i class="fa-solid fa-triangle-exclamation text-4xl"></i>
            </div>

            <div class="inline-block px-4 py-1.5 rounded-full bg-rose-50 text-rose-800 border border-rose-300 text-xs font-black uppercase tracking-wider mb-2">
                ❌ KTA TIDAK TERDAFTAR / INVALID
            </div>

            <h1 class="font-heading text-2xl sm:text-3xl font-extrabold text-slate-900 mb-2">
                Verifikasi Tidak Ditemukan
            </h1>
            <p class="text-slate-600 text-sm max-w-lg mx-auto mb-8">
                {{ $message ?? 'Data KTA tidak ditemukan atau kartu belum disetujui oleh Administrator IKA SMAN Kajuara.' }}
            </p>

            <div class="flex items-center justify-center space-x-3">
                <a href="{{ route('kta.index') }}" class="px-6 py-3 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs uppercase tracking-wider rounded-2xl shadow-lg transition flex items-center">
                    <i class="fa-solid fa-search mr-2 text-amber-400"></i>Cari KTA Alumni
                </a>
            </div>
        @endif

    </div>

</div>
@endsection
