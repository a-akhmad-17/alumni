@extends('layouts.app')

@section('title', 'KTA Digital Alumni - IKA SMAN Kajuara / SMAN 8 Bone')
@section('meta_description', 'Kartu Tanda Anggota (KTA) Digital Resmi Alumni IKA SMAN Kajuara / SMAN 8 Bone. Cetak dan unduh KTA dengan verifikasi QR Code resmi.')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10" x-data="{ isFlipped: false }">

    <!-- Header Banner -->
    <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6 no-print">
        <div>
            <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-900 border border-amber-300 text-xs font-black uppercase tracking-wider inline-block mb-2">
                <i class="fa-solid fa-id-card mr-1 text-amber-600"></i>Kartu Anggota Digital
            </span>
            <h1 class="font-heading text-3xl sm:text-4xl font-extrabold text-slate-900">KTA Digital Alumni IKA SMAN Kajuara</h1>
            <p class="text-slate-600 text-sm mt-1">Cari data alumni terverifikasi, lihat Kartu Tanda Anggota (KTA) digital resmi, dan unduh/cetak kartu Boss.</p>
        </div>

        <div class="flex items-center space-x-3">
            <a href="{{ route('alumni.index') }}" class="px-5 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs uppercase tracking-wider rounded-2xl border border-slate-300 transition flex items-center">
                <i class="fa-solid fa-users mr-2"></i>Direktori Alumni
            </a>
        </div>
    </div>

    <!-- Main Grid: Left (Card Preview & Actions) & Right (Alumni Selector & Search) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start mb-12 no-print">
        
        <!-- LEFT COLUMN: 3D Flip Card Preview & Controls -->
        <div class="lg:col-span-6 flex flex-col items-center">
            
            @if($selectedAlumni)
                @php
                    $verifyUrl = url('/kta/verify/' . $selectedAlumni->id);
                    $qrApiUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&margin=1&format=png&data=' . urlencode($verifyUrl);
                    $qrDataUri = '';
                    try {
                        $qrRaw = @file_get_contents($qrApiUrl);
                        if ($qrRaw) {
                            $qrDataUri = 'data:image/png;base64,' . base64_encode($qrRaw);
                        }
                    } catch (\Throwable $e) {}
                    if (!$qrDataUri) {
                        $qrDataUri = $qrApiUrl;
                    }
                @endphp

                <!-- Card Container Container with Flip animation -->
                <div class="w-full max-w-md perspective-1000 mb-6">
                    <div id="ktaCardContainer" class="relative w-full aspect-[85/54] rounded-3xl transition-transform duration-700 transform-style-3d shadow-2xl cursor-pointer group"
                         :class="{ 'rotate-y-180': isFlipped }"
                         @click="isFlipped = !isFlipped">
                        
                        <!-- ================= CARD FRONT (TAMPAK DEPAN PREVIEW) ================= -->
                        <div class="absolute inset-0 w-full h-full rounded-3xl p-4 sm:p-5 bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950 text-white border-2 border-amber-500/40 shadow-2xl flex flex-col justify-between overflow-hidden backface-hidden">
                            <!-- Background Metallic Accents -->
                            <div class="absolute -top-12 -right-12 w-44 h-44 bg-amber-500/10 rounded-full blur-2xl pointer-events-none"></div>
                            <div class="absolute -bottom-12 -left-12 w-44 h-44 bg-amber-600/10 rounded-full blur-2xl pointer-events-none"></div>
                            <div class="absolute inset-0 bg-[radial-gradient(#d97706_1px,transparent_1px)] [background-size:16px_16px] opacity-10 pointer-events-none"></div>

                            <!-- Header Kartu -->
                            <div class="relative z-10 flex items-center justify-between border-b border-amber-500/30 pb-2">
                                <div class="flex items-center space-x-3">
                                    <img src="{{ asset('assets/images/logo.webp') }}" alt="Logo IKA" class="h-9 sm:h-10 w-auto object-contain drop-shadow-md">
                                    <div>
                                        <h3 class="font-heading font-extrabold text-xs tracking-tight text-amber-400 leading-tight uppercase">
                                            IKA SMAN KAJUARA / SMAN 8 BONE
                                        </h3>
                                        <span class="text-[9px] font-bold tracking-widest uppercase text-slate-300 block">
                                            KARTU TANDA ANGGOTA RESMI
                                        </span>
                                    </div>
                                </div>
                                <div class="px-2 py-0.5 rounded-full bg-emerald-500/20 border border-emerald-400/40 text-emerald-300 text-[9px] font-black tracking-wider uppercase flex items-center space-x-1 shrink-0">
                                    <i class="fa-solid fa-circle-check text-[10px]"></i>
                                    <span>VERIFIED</span>
                                </div>
                            </div>

                            <!-- Body Kartu: Foto & Details (Ukuran Foto Tetap / Fixed) -->
                            <div class="relative z-10 flex items-center space-x-3.5 py-1">
                                <!-- Foto Frame (Ukuran Tetap 80px x 100px) -->
                                <div class="w-[80px] h-[100px] min-w-[80px] min-h-[100px] rounded-2xl p-0.5 bg-gradient-to-b from-amber-400 via-amber-600 to-amber-300 shadow-xl overflow-hidden shrink-0">
                                    @if($selectedAlumni->foto)
                                        <img src="{{ asset($selectedAlumni->foto) }}" alt="{{ $selectedAlumni->nama }}" class="w-full h-full object-cover rounded-[14px]">
                                    @else
                                        <div class="w-full h-full bg-slate-900 rounded-[14px] flex items-center justify-center text-amber-400 font-heading font-extrabold text-2xl">
                                            {{ substr($selectedAlumni->nama, 0, 2) }}
                                        </div>
                                    @endif
                                </div>

                                <!-- Detail Info Alumni -->
                                <div class="flex-1 min-w-0 space-y-1">
                                    <h2 class="font-heading font-bold text-sm sm:text-base text-white truncate leading-snug drop-shadow-sm">
                                        {{ $selectedAlumni->nama }}
                                    </h2>

                                    <div class="inline-block px-2.5 py-0.5 rounded-md bg-amber-500/20 border border-amber-400/30 text-amber-300 text-[10px] font-extrabold tracking-wider uppercase">
                                        Angkatan {{ $selectedAlumni->angkatan }}
                                    </div>

                                    <p class="text-[11px] text-slate-300 font-medium truncate pt-0.5">
                                        <i class="fa-solid fa-location-dot text-amber-400 mr-1 text-[10px]"></i>
                                        Domisili: {{ $selectedAlumni->domisili ?? 'Kajuara, Kab. Bone' }}
                                    </p>

                                    <div class="pt-1 border-t border-slate-800 flex items-center justify-between">
                                        <span class="text-[9px] font-mono text-slate-400 tracking-wider">
                                            KTA: <strong class="text-amber-400 font-bold">KTA-IKA.{{ $selectedAlumni->angkatan }}.{{ strtoupper(substr(md5($selectedAlumni->id), 0, 5)) }}</strong>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Footer Kartu: QR Code & Signature -->
                            <div class="relative z-10 flex items-end justify-between border-t border-amber-500/20 pt-1">
                                <div class="flex items-center space-x-2">
                                    <!-- QR Code Verified -->
                                    <div class="p-1 bg-white rounded-xl shadow-md shrink-0 border border-slate-200">
                                        <img src="{{ $qrDataUri }}" alt="QR Verifikasi" class="w-10 h-10 object-contain rounded-lg">
                                    </div>
                                    <div>
                                        <span class="text-[8px] text-slate-300 block leading-tight">Scan untuk Validasi</span>
                                        <span class="text-[9px] font-extrabold text-amber-400 block tracking-tight">ikasman8bone.id</span>
                                    </div>
                                </div>

                                <div class="text-right">
                                    <span class="text-[8px] uppercase tracking-widest text-slate-400 block">Ketua Umum IKA</span>
                                    <span class="text-[10px] font-bold text-amber-300 block leading-tight">Dr. H. Andi Akmal Pasluddin, M.M.</span>
                                </div>
                            </div>

                        </div>

                        <!-- ================= CARD BACK (TAMPAK BELAKANG PREVIEW) ================= -->
                        <div class="absolute inset-0 w-full h-full rounded-3xl p-4 sm:p-5 bg-gradient-to-br from-slate-900 via-slate-950 to-slate-900 text-white border-2 border-amber-500/40 shadow-2xl flex flex-col justify-between overflow-hidden backface-hidden rotate-y-180">
                            <!-- Background Pattern -->
                            <div class="absolute inset-0 bg-[radial-gradient(#d97706_1px,transparent_1px)] [background-size:16px_16px] opacity-10 pointer-events-none"></div>

                            <!-- Header Tampak Belakang -->
                            <div class="relative z-10 border-b border-amber-500/30 pb-2 flex items-center justify-between">
                                <span class="font-heading font-extrabold text-[11px] text-amber-400 uppercase tracking-wider">
                                    KETENTUAN KARTU ANGGOTA
                                </span>
                                <span class="text-[9px] text-slate-400">IKA SMAN KAJUARA</span>
                            </div>

                            <!-- Terms Content -->
                            <div class="relative z-10 space-y-1.5 text-[10px] text-slate-300 py-2 leading-relaxed">
                                <p class="flex items-start space-x-1.5">
                                    <span class="text-amber-400 font-bold">1.</span>
                                    <span>Kartu ini merupakan identitas resmi anggota Ikatan Alumni SMAN Kajuara / SMAN 8 Bone.</span>
                                </p>
                                <p class="flex items-start space-x-1.5">
                                    <span class="text-amber-400 font-bold">2.</span>
                                    <span>Pemegang kartu berhak mendapatkan akses jaringan alumni, program kemitraan, dan kegiatan IKA.</span>
                                </p>
                                <p class="flex items-start space-x-1.5">
                                    <span class="text-amber-400 font-bold">3.</span>
                                    <span>Keaslian kartu terjamin secara digital dan dapat diverifikasi via scan QR Code.</span>
                                </p>
                            </div>

                            <!-- Footer Tampak Belakang -->
                            <div class="relative z-10 border-t border-amber-500/20 pt-2 flex items-end justify-between">
                                <div>
                                    <span class="text-[8px] text-slate-400 uppercase block">Sekretariat IKA:</span>
                                    <span class="text-[9px] font-semibold text-slate-200 block">Kajuara, Kab. Bone, Sulawesi Selatan</span>
                                </div>
                                <div class="px-2.5 py-1 rounded-lg bg-amber-500/20 border border-amber-400/30 text-amber-400 text-[9px] font-bold uppercase tracking-wider">
                                    OFFICIAL MEMBER
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Helper Text & Control Buttons -->
                <p class="text-xs text-slate-500 mb-4 flex items-center space-x-1">
                    <i class="fa-solid fa-rotate text-amber-600 animate-spin-slow"></i>
                    <span>Klik atau tap pada kartu untuk membalikkan tampilan (Depan / Belakang).</span>
                </p>

                <!-- Action Buttons: Rotate, Download Both (PNG), & Print PDF -->
                <div class="flex flex-wrap items-center justify-center gap-3 w-full max-w-lg">
                    <button @click="isFlipped = !isFlipped" class="px-4 py-2.5 bg-slate-200 hover:bg-slate-300 text-slate-800 font-bold text-xs rounded-xl transition flex items-center shadow-sm">
                        <i class="fa-solid fa-rotate-left mr-1.5"></i>Balik Kartu
                    </button>

                    <!-- Single Download Button (Auto Download Both PNG Files) -->
                    <button onclick="downloadKtaAll(this)" class="px-5 py-2.5 bg-amber-500 hover:bg-amber-600 text-slate-950 font-extrabold text-xs uppercase tracking-wider rounded-xl shadow-lg transition flex items-center cursor-pointer">
                        <i class="fa-solid fa-download mr-2"></i>Unduh KTA Digital (PNG)
                    </button>

                    <button onclick="window.print()" class="px-4 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-extrabold text-xs uppercase tracking-wider rounded-xl shadow-lg transition flex items-center border border-slate-700 cursor-pointer">
                        <i class="fa-solid fa-print mr-1.5 text-amber-400"></i>Cetak Kartu (PDF)
                    </button>
                </div>
            @else
                <div class="w-full max-w-md p-10 text-center glass-card rounded-3xl bg-white border border-slate-200">
                    <i class="fa-solid fa-id-card-clip text-5xl text-amber-500/40 mb-3 block"></i>
                    <h3 class="font-heading font-bold text-slate-900 text-lg">Kartu Belum Dipilih</h3>
                    <p class="text-slate-500 text-xs mt-1">Silakan cari atau pilih alumni pada panel di sebelah kanan untuk menampilkan preview KTA Digital.</p>
                </div>
            @endif

        </div>

        <!-- RIGHT COLUMN: Alumni Search & Selector -->
        <div class="lg:col-span-6">
            <div class="glass-card rounded-3xl p-6 bg-white border border-slate-200 shadow-sm">
                
                <div class="flex items-center justify-between mb-5 pb-3 border-b border-slate-100">
                    <div>
                        <h3 class="font-heading font-bold text-lg text-slate-900">Pilih / Cari Alumni</h3>
                        <p class="text-slate-500 text-xs">Cari nama atau angkatan untuk menampilkan KTA Digital resmi.</p>
                    </div>
                    <span class="px-3 py-1 rounded-full bg-amber-50 text-amber-900 border border-amber-200 text-xs font-bold">
                        {{ $alumniList->total() }} Alumni Terverifikasi
                    </span>
                </div>

                <!-- Form Search & Filter -->
                <form action="{{ route('kta.index') }}" method="GET" class="space-y-4 mb-6">
                    <div class="grid grid-cols-1 sm:grid-cols-12 gap-3">
                        <div class="sm:col-span-7">
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                                    <i class="fa-solid fa-search"></i>
                                </span>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama alumni / domisili..." class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-900 transition">
                            </div>
                        </div>

                        <div class="sm:col-span-5">
                            <select name="angkatan" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-900 transition">
                                <option value="">Semua Angkatan</option>
                                @foreach($angkatanList as $thn)
                                    <option value="{{ $thn }}" {{ request('angkatan') == $thn ? 'selected' : '' }}>Angkatan {{ $thn }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-2">
                        @if(request()->hasAny(['search', 'angkatan']))
                            <a href="{{ route('kta.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl border border-slate-300 flex items-center">
                                <i class="fa-solid fa-rotate-left mr-1"></i>Reset
                            </a>
                        @endif
                        <button type="submit" class="px-5 py-2 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-xl shadow-md flex items-center">
                            <i class="fa-solid fa-filter mr-1.5 text-amber-400"></i>Terapkan Filter
                        </button>
                    </div>
                </form>

                <!-- List Alumni Selection Grid -->
                <div class="space-y-2.5 max-h-[420px] overflow-y-auto pr-1">
                    @forelse($alumniList as $alumni)
                        <a href="{{ route('kta.index', array_merge(request()->query(), ['id' => $alumni->id])) }}"
                           class="flex items-center justify-between p-3.5 rounded-2xl border transition duration-200 {{ ($selectedAlumni && $selectedAlumni->id === $alumni->id) ? 'bg-amber-500/10 border-amber-500/50 shadow-sm' : 'bg-slate-50 border-slate-200 hover:bg-slate-100' }}">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-xl bg-slate-900 text-white p-0.5 shrink-0 overflow-hidden">
                                    @if($alumni->foto)
                                        <img src="{{ asset($alumni->foto) }}" alt="{{ $alumni->nama }}" class="w-full h-full object-cover rounded-[10px]">
                                    @else
                                        <div class="w-full h-full bg-slate-900 rounded-[10px] flex items-center justify-center text-amber-400 font-heading font-bold text-xs">
                                            {{ substr($alumni->nama, 0, 2) }}
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <h4 class="font-heading font-bold text-sm text-slate-900 leading-tight">{{ $alumni->nama }}</h4>
                                    <p class="text-xs text-slate-500"><i class="fa-solid fa-location-dot mr-1 text-[10px] text-amber-600"></i>{{ $alumni->domisili ?? 'Kajuara, Bone' }}</p>
                                </div>
                            </div>

                            <div class="text-right shrink-0">
                                <span class="px-2.5 py-1 rounded-full bg-white border border-slate-200 text-slate-800 text-[10px] font-bold">
                                    Angkatan {{ $alumni->angkatan }}
                                </span>
                            </div>
                        </a>
                    @empty
                        <div class="py-10 text-center text-slate-500">
                            <i class="fa-solid fa-user-slash text-3xl mb-2 text-slate-400"></i>
                            <p class="text-xs">Data alumni tidak ditemukan.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="mt-4 pt-3 border-t border-slate-100">
                    {{ $alumniList->links() }}
                </div>

            </div>
        </div>

    </div>

</div>

@if($selectedAlumni)
<!-- ================= DEDICATED OFF-SCREEN CAPTURE & PRINT AREA (PURE FLEXBOX & FIXED PHOTO) ================= -->
<div id="ktaPrintArea">
    <div class="text-center mb-3">
        <h2 class="text-base font-bold text-slate-900 uppercase tracking-tight">KARTU TANDA ANGGOTA (KTA) DIGITAL RESMI</h2>
        <p class="text-xs text-slate-600 font-semibold">IKATAN KELUARGA ALUMNI (IKA) SMAN KAJUARA / SMAN 8 BONE</p>
    </div>

    <div class="print-cards-grid">
        <!-- TAMPAK DEPAN (PRINT & CAPTURE) -->
        <div id="ktaFrontCapture" style="width: 450px; height: 285px; padding: 18px; background-color: #0f172a; color: #ffffff; border: 2px solid #f59e0b; border-radius: 20px; box-sizing: border-box; display: flex; flex-direction: column; justify-content: space-between; position: relative; font-family: system-ui, -apple-system, sans-serif;">
            
            <!-- Header Kartu -->
            <div style="display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid rgba(245, 158, 11, 0.4); padding-bottom: 8px;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <img src="{{ asset('assets/images/logo.webp') }}" alt="Logo IKA" style="height: 36px; width: auto; object-fit: contain;">
                    <div>
                        <div style="font-size: 11px; font-weight: 800; color: #fbbf24; text-transform: uppercase; letter-spacing: 0.5px; line-height: 14px;">
                            IKA SMAN KAJUARA / SMAN 8 BONE
                        </div>
                        <div style="font-size: 8px; font-weight: 700; color: #cbd5e1; text-transform: uppercase; letter-spacing: 1px; margin-top: 2px;">
                            KARTU TANDA ANGGOTA RESMI
                        </div>
                    </div>
                </div>
                <div style="padding: 2px 8px; background-color: rgba(16, 185, 129, 0.2); border: 1px solid rgba(52, 211, 153, 0.4); color: #6ee7b7; font-size: 8px; font-weight: 900; letter-spacing: 1px; border-radius: 9999px; text-transform: uppercase;">
                    VERIFIED
                </div>
            </div>

            <!-- Body Kartu: Foto Tetap (Fixed 90px x 115px) & Flex Details -->
            <div style="display: flex; align-items: center; gap: 14px; margin: 4px 0;">
                <!-- Frame Foto Ukuran Tetap (Tidak Dinamis) -->
                <div style="width: 90px; height: 115px; min-width: 90px; min-height: 115px; border-radius: 14px; padding: 2px; background: linear-gradient(to bottom, #fbbf24, #d97706, #fef08a); box-sizing: border-box; overflow: hidden; flex-shrink: 0;">
                    @if($selectedAlumni->foto)
                        <img src="{{ asset($selectedAlumni->foto) }}" alt="{{ $selectedAlumni->nama }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 12px; display: block;">
                    @else
                        <div style="width: 100%; height: 100%; background-color: #0f172a; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #fbbf24; font-weight: 800; font-size: 22px;">
                            {{ substr($selectedAlumni->nama, 0, 2) }}
                        </div>
                    @endif
                </div>

                <!-- Info Detail Alumni -->
                <div style="flex: 1; min-width: 0; display: flex; flex-direction: column; justify-content: center;">
                    <div style="font-size: 15px; font-weight: 800; color: #ffffff; line-height: 20px; margin-bottom: 6px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        {{ $selectedAlumni->nama }}
                    </div>

                    <div style="margin-bottom: 6px;">
                        <span style="display: inline-block; padding: 3px 10px; background-color: rgba(245, 158, 11, 0.2); border: 1px solid rgba(251, 191, 36, 0.3); color: #fef08a; font-size: 10px; font-weight: 800; border-radius: 6px; text-transform: uppercase; letter-spacing: 0.5px;">
                            Angkatan {{ $selectedAlumni->angkatan }}
                        </span>
                    </div>

                    <div style="font-size: 11px; color: #cbd5e1; font-weight: 500; line-height: 16px; margin-bottom: 6px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        <span style="color: #fbbf24; margin-right: 4px;">📍</span>
                        Domisili: {{ $selectedAlumni->domisili ?? 'Kajuara, Kab. Bone' }}
                    </div>

                    <div style="border-top: 1px solid #1e293b; padding-top: 4px; font-size: 9px; font-family: monospace; color: #94a3b8; letter-spacing: 0.5px;">
                        KTA: <strong style="color: #fbbf24; font-weight: 700;">KTA-IKA.{{ $selectedAlumni->angkatan }}.{{ strtoupper(substr(md5($selectedAlumni->id), 0, 5)) }}</strong>
                    </div>
                </div>
            </div>

            <!-- Footer Kartu -->
            <div style="display: flex; align-items: flex-end; justify-content: space-between; border-top: 1px solid rgba(245, 158, 11, 0.3); padding-top: 6px;">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <div style="padding: 3px; background-color: #ffffff; border-radius: 8px; border: 1px solid #e2e8f0; line-height: 0;">
                        <img src="{{ $qrDataUri }}" alt="QR Verifikasi" style="width: 36px; height: 36px; object-fit: contain; display: block;">
                    </div>
                    <div>
                        <div style="font-size: 7.5px; color: #cbd5e1; line-height: 10px;">Scan untuk Validasi</div>
                        <div style="font-size: 8.5px; font-weight: 800; color: #fbbf24; line-height: 11px;">ikasman8bone.id</div>
                    </div>
                </div>

                <div style="text-align: right;">
                    <div style="font-size: 7.5px; text-transform: uppercase; letter-spacing: 1px; color: #94a3b8; line-height: 10px;">Ketua Umum IKA</div>
                    <div style="font-size: 9.5px; font-weight: 700; color: #fef08a; line-height: 13px;">Dr. H. Andi Akmal Pasluddin, M.M.</div>
                </div>
            </div>

        </div>

        <!-- TAMPAK BELAKANG (PRINT & CAPTURE) -->
        <div id="ktaBackCapture" style="width: 450px; height: 285px; padding: 18px; background-color: #0f172a; color: #ffffff; border: 2px solid #f59e0b; border-radius: 20px; box-sizing: border-box; display: flex; flex-direction: column; justify-content: space-between; position: relative; font-family: system-ui, -apple-system, sans-serif;">
            <div style="border-bottom: 1px solid rgba(245, 158, 11, 0.4); padding-bottom: 6px; display: flex; align-items: center; justify-content: space-between;">
                <span style="font-size: 11px; font-weight: 800; color: #fbbf24; text-transform: uppercase; letter-spacing: 1px;">
                    KETENTUAN KARTU ANGGOTA
                </span>
                <span style="font-size: 8.5px; color: #94a3b8;">IKA SMAN KAJUARA / SMAN 8 BONE</span>
            </div>

            <div style="padding: 10px 0; font-size: 10.5px; color: #cbd5e1; line-height: 18px;">
                <div style="margin-bottom: 6px; display: flex; gap: 6px;">
                    <strong style="color: #fbbf24;">1.</strong>
                    <span>Kartu ini merupakan identitas resmi anggota Ikatan Alumni SMAN Kajuara / SMAN 8 Bone.</span>
                </div>
                <div style="margin-bottom: 6px; display: flex; gap: 6px;">
                    <strong style="color: #fbbf24;">2.</strong>
                    <span>Pemegang kartu berhak mendapatkan akses jaringan alumni, program kemitraan, dan kegiatan IKA.</span>
                </div>
                <div style="margin-bottom: 6px; display: flex; gap: 6px;">
                    <strong style="color: #fbbf24;">3.</strong>
                    <span>Keaslian kartu terjamin secara digital dan dapat diverifikasi via scan QR Code.</span>
                </div>
            </div>

            <div style="border-top: 1px solid rgba(245, 158, 11, 0.3); padding-top: 6px; display: flex; align-items: flex-end; justify-content: space-between;">
                <div>
                    <div style="font-size: 7.5px; color: #94a3b8; text-transform: uppercase;">Sekretariat IKA:</div>
                    <div style="font-size: 9px; font-weight: 600; color: #e2e8f0; margin-top: 2px;">Kajuara, Kab. Bone, Sulawesi Selatan</div>
                </div>
                <div style="padding: 3px 10px; background-color: rgba(245, 158, 11, 0.2); border: 1px solid rgba(251, 191, 36, 0.3); color: #fbbf24; font-size: 8.5px; font-weight: 800; border-radius: 6px; text-transform: uppercase; letter-spacing: 0.5px;">
                    OFFICIAL MEMBER
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Script html2canvas untuk Unduh Otomatis 2 Berkas PNG (Depan & Belakang) -->
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
    function downloadKtaAll(btn) {
        var originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fa-solid fa-spinner animate-spin mr-1.5"></i> Mengunduh KTA...';
        btn.disabled = true;

        var elFront = document.getElementById('ktaFrontCapture');
        var elBack = document.getElementById('ktaBackCapture');

        if (!elFront || !elBack) {
            alert('Elemen kartu KTA tidak ditemukan.');
            btn.innerHTML = originalText;
            btn.disabled = false;
            return;
        }

        // Jalankan html2canvas dengan skala 3x Ultra HD
        html2canvas(elFront, {
            scale: 3,
            useCORS: true,
            allowTaint: true,
            backgroundColor: '#0f172a',
            logging: false
        }).then(function(canvasFront) {
            try {
                var aFront = document.createElement('a');
                aFront.download = 'KTA-Depan-{{ Str::slug($selectedAlumni->nama ?? "Alumni") }}.png';
                aFront.href = canvasFront.toDataURL('image/png');
                document.body.appendChild(aFront);
                aFront.click();
                document.body.removeChild(aFront);
            } catch(e) {
                console.error("Download front error:", e);
            }

            setTimeout(function() {
                html2canvas(elBack, {
                    scale: 3,
                    useCORS: true,
                    allowTaint: true,
                    backgroundColor: '#0f172a',
                    logging: false
                }).then(function(canvasBack) {
                    try {
                        var aBack = document.createElement('a');
                        aBack.download = 'KTA-Belakang-{{ Str::slug($selectedAlumni->nama ?? "Alumni") }}.png';
                        aBack.href = canvasBack.toDataURL('image/png');
                        document.body.appendChild(aBack);
                        aBack.click();
                        document.body.removeChild(aBack);
                    } catch(e) {
                        console.error("Download back error:", e);
                    }

                    btn.innerHTML = originalText;
                    btn.disabled = false;
                }).catch(function(err) {
                    console.error("Gagal html2canvas belakang:", err);
                    alert("Gagal memproses gambar KTA Belakang. Silakan coba lagi.");
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                });
            }, 600);
        }).catch(function(err) {
            console.error("Gagal html2canvas depan:", err);
            alert("Gagal memproses gambar KTA Depan. Silakan coba lagi.");
            btn.innerHTML = originalText;
            btn.disabled = false;
        });
    }
</script>
@endpush

<!-- Styles for 3D Card Flip & Off-screen Capture / Forced High-Contrast Print View -->
<style>
    .perspective-1000 {
        perspective: 1000px;
    }
    .transform-style-3d {
        transform-style: preserve-3d;
    }
    .backface-hidden {
        backface-visibility: hidden;
        -webkit-backface-visibility: hidden;
    }
    .rotate-y-180 {
        transform: rotateY(180deg);
    }
    .animate-spin-slow {
        animation: spin 6s linear infinite;
    }
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    /* Render capture container off-screen so html2canvas has REAL layout size without being visible */
    #ktaPrintArea {
        position: absolute;
        left: -9999px;
        top: -9999px;
        width: 450px;
        opacity: 1;
        pointer-events: none;
    }

    /* Dedicated Print Media Rules */
    @media print {
        *, *::before, *::after {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            color-adjust: exact !important;
        }

        body {
            background: #ffffff !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        header, footer, nav, button, form, .no-print, .perspective-1000 {
            display: none !important;
        }

        #ktaPrintArea {
            position: absolute !important;
            left: 0 !important;
            top: 0 !important;
            width: 100% !important;
            background: #ffffff !important;
            padding: 10mm !important;
            pointer-events: auto !important;
        }

        #ktaPrintArea * {
            visibility: visible !important;
        }

        .print-cards-grid {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            gap: 10mm !important;
            margin-top: 5mm !important;
        }

        #ktaFrontCapture, #ktaBackCapture {
            width: 85.6mm !important;
            height: 53.98mm !important;
            min-height: 53.98mm !important;
            padding: 4mm !important;
            page-break-inside: avoid !important;
            background-color: #0f172a !important;
            color: #ffffff !important;
            border: 2px solid #d97706 !important;
            border-radius: 16px !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        #ktaFrontCapture img, #ktaBackCapture img {
            max-width: 100% !important;
            display: block !important;
            visibility: visible !important;
        }
    }
</style>
@endsection
