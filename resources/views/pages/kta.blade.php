@extends('layouts.app')

@section('title', 'KTA Digital Alumni - IKA SMAN Kajuara / SMAN 8 Bone')
@section('meta_description', 'Kartu Tanda Anggota (KTA) Digital Resmi Alumni IKA SMAN Kajuara / SMAN 8 Bone. Cetak KTA dengan verifikasi QR Code resmi.')

@section('content')
<div id="kta-root-container"
     class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10" 
     x-data="{ 
         isFlipped: false, 
         selectedIds: [{{ $selectedAlumni ? $selectedAlumni->id : 0 }}], 
         selectAll: false, 
         toggleAll() { 
             if (this.selectAll) { 
                 this.selectedIds = [{{ implode(',', $alumniList->pluck('id')->toArray()) }}]; 
             } else { 
                 this.selectedIds = []; 
             } 
         },
         doPrint() {
             var currentSelected = this.selectedIds || [];
             var rows = document.querySelectorAll('.kta-print-row');
             if (rows && rows.length > 0) {
                 rows.forEach(function(row) {
                     var rowId = parseInt(row.getAttribute('data-alumni-id'));
                     if (currentSelected.length > 0) {
                         if (currentSelected.includes(rowId) || currentSelected.includes(rowId.toString())) {
                             row.style.display = 'flex';
                         } else {
                             row.style.display = 'none';
                         }
                     } else {
                         row.style.display = 'flex';
                     }
                 });
             }
             window.print();
         }
     }">

    <!-- Header Banner -->
    <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6 no-print">
        <div>
            <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-900 border border-amber-300 text-xs font-black uppercase tracking-wider inline-block mb-2">
                <i class="fa-solid fa-id-card mr-1 text-amber-600"></i>Kartu Anggota Digital
            </span>
            <h1 class="font-heading text-3xl sm:text-4xl font-extrabold text-slate-900">KTA Digital Alumni IKA SMAN Kajuara</h1>
            <p class="text-slate-600 text-sm mt-1">Cari data alumni terverifikasi, lihat Kartu Tanda Anggota (KTA) digital resmi, dan cetak kartu secara massal (PDF).</p>
        </div>

        <div class="flex items-center space-x-3">
            <a href="{{ route('alumni.index') }}" class="px-5 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs uppercase tracking-wider rounded-2xl border border-slate-300 transition flex items-center">
                <i class="fa-solid fa-users mr-2"></i>Direktori Alumni
            </a>
        </div>
    </div>

    <!-- Main Grid: Left (Card Preview & Actions) & Right (Alumni Selector & Multi-Check) -->
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

                <!-- Card Container with 3D Flip Animation -->
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

                            <!-- Body Kartu: Foto & Details -->
                            <div class="relative z-10 flex items-center space-x-4 py-1">
                                <!-- Foto Frame (Ukuran Tetap 105px x 120px dengan Border Emas Melengkung) -->
                                <div class="w-[105px] h-[120px] min-w-[105px] min-h-[120px] rounded-2xl p-0.5 bg-gradient-to-b from-amber-400 via-amber-600 to-amber-300 shadow-xl overflow-hidden shrink-0">
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

                <!-- Action Buttons: Rotate & Print PDF -->
                <div class="flex flex-wrap items-center justify-center gap-3 w-full max-w-lg">
                    <button @click="isFlipped = !isFlipped" type="button" class="px-5 py-3 bg-slate-200 hover:bg-slate-300 text-slate-800 font-bold text-xs rounded-xl transition flex items-center shadow-sm">
                        <i class="fa-solid fa-rotate-left mr-2"></i>Balik Kartu
                    </button>

                    <!-- Main Batch Print PDF Button (Linked to Alpine doPrint method) -->
                    <button @click="doPrint()" type="button" class="px-6 py-3 bg-slate-900 hover:bg-slate-800 text-white font-extrabold text-xs uppercase tracking-wider rounded-xl shadow-xl transition flex items-center border border-slate-700 cursor-pointer">
                        <i class="fa-solid fa-print mr-2 text-amber-400 text-sm"></i>
                        <span>Cetak KTA Terpilih (PDF)</span>
                        <span x-show="selectedIds.length > 0" class="ml-2 px-2 py-0.5 rounded-full bg-amber-500 text-slate-950 font-black text-[10px]" x-text="selectedIds.length"></span>
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

        <!-- RIGHT COLUMN: Alumni Search, Multi-Select & Batch Selector -->
        <div class="lg:col-span-6">
            <div class="glass-card rounded-3xl p-6 bg-white border border-slate-200 shadow-sm">
                
                <div class="flex items-center justify-between mb-5 pb-3 border-b border-slate-100">
                    <div>
                        <h3 class="font-heading font-bold text-lg text-slate-900">Pilih & Centang KTA Alumni</h3>
                        <p class="text-slate-500 text-xs">Centang alumni yang ingin dicetak sekaligus pada kertas A4 (PDF).</p>
                    </div>
                    <span class="px-3 py-1 rounded-full bg-amber-50 text-amber-900 border border-amber-200 text-xs font-bold">
                        {{ $alumniList->total() }} Terverifikasi
                    </span>
                </div>

                <!-- Form Search & Filter -->
                <form action="{{ route('kta.index') }}" method="GET" class="space-y-4 mb-5">
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

                <!-- Select All Bar -->
                <div class="flex items-center justify-between px-3 py-2 bg-slate-100 rounded-xl mb-3 border border-slate-200">
                    <label class="flex items-center space-x-2 text-xs font-extrabold text-slate-800 cursor-pointer">
                        <input type="checkbox" x-model="selectAll" @change="toggleAll()" class="w-4 h-4 text-amber-500 rounded border-slate-300 focus:ring-amber-400">
                        <span>Pilih Semua di Halaman Ini ({{ $alumniList->count() }} Alumni)</span>
                    </label>
                    <span class="text-[11px] font-bold text-amber-700" x-show="selectedIds.length > 0">
                        <i class="fa-solid fa-check-double mr-1"></i><span x-text="selectedIds.length"></span> Dicentang
                    </span>
                </div>

                <!-- List Alumni Selection Grid with Multi Checkboxes -->
                <div class="space-y-2.5 max-h-[420px] overflow-y-auto pr-1">
                    @forelse($alumniList as $alumni)
                        <div class="flex items-center justify-between p-3 rounded-2xl border transition duration-200 {{ ($selectedAlumni && $selectedAlumni->id === $alumni->id) ? 'bg-amber-500/10 border-amber-500/50 shadow-sm' : 'bg-slate-50 border-slate-200 hover:bg-slate-100' }}">
                            <div class="flex items-center space-x-3">
                                <!-- Checkbox Multi Select -->
                                <input type="checkbox" value="{{ $alumni->id }}" x-model="selectedIds" class="w-4 h-4 text-amber-600 rounded border-slate-300 focus:ring-amber-400 cursor-pointer shrink-0">

                                <!-- Foto & Info (Klik untuk Preview 3D) -->
                                <a href="{{ route('kta.index', array_merge(request()->query(), ['id' => $alumni->id])) }}" class="flex items-center space-x-3 flex-1 min-w-0">
                                    <div class="w-10 h-10 rounded-xl bg-slate-900 text-white p-0.5 shrink-0 overflow-hidden">
                                        @if($alumni->foto)
                                            <img src="{{ asset($alumni->foto) }}" alt="{{ $alumni->nama }}" class="w-full h-full object-cover rounded-[10px]">
                                        @else
                                            <div class="w-full h-full bg-slate-900 rounded-[10px] flex items-center justify-center text-amber-400 font-heading font-bold text-xs">
                                                {{ substr($alumni->nama, 0, 2) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="truncate">
                                        <h4 class="font-heading font-bold text-sm text-slate-900 leading-tight truncate">{{ $alumni->nama }}</h4>
                                        <p class="text-xs text-slate-500 truncate"><i class="fa-solid fa-location-dot mr-1 text-[10px] text-amber-600"></i>{{ $alumni->domisili ?? 'Kajuara, Bone' }}</p>
                                    </div>
                                </a>
                            </div>

                            <div class="text-right shrink-0">
                                <span class="px-2.5 py-1 rounded-full bg-white border border-slate-200 text-slate-800 text-[10px] font-bold">
                                    Angkatan {{ $alumni->angkatan }}
                                </span>
                            </div>
                        </div>
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

<!-- ================= DEDICATED A4 PRINT LAYOUT FOR MULTIPLE KTA CARDS ================= -->
<div id="ktaPrintArea">
    <div class="text-center mb-6 no-print-head">
        <h2 class="text-lg font-bold text-slate-900 uppercase tracking-tight">KARTU TANDA ANGGOTA (KTA) DIGITAL RESMI ALUMNI</h2>
        <p class="text-xs text-slate-600 font-semibold">IKATAN KELUARGA ALUMNI (IKA) SMAN KAJUARA / SMAN 8 BONE</p>
    </div>

    <div class="print-cards-grid">
        @foreach($alumniList as $alumni)
            @php
                $vUrl = url('/kta/verify/' . $alumni->id);
                $qUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&margin=1&format=png&data=' . urlencode($vUrl);
                $qUri = '';
                try {
                    $qRaw = @file_get_contents($qUrl);
                    if ($qRaw) {
                        $qUri = 'data:image/png;base64,' . base64_encode($qRaw);
                    }
                } catch (\Throwable $e) {}
                if (!$qUri) {
                    $qUri = $qUrl;
                }
            @endphp
            <!-- 1 ROW PAIR PER ALUMNI: FRONT (LEFT) & BACK (RIGHT) -->
            <div class="kta-print-row" data-alumni-id="{{ $alumni->id }}">
                
                <!-- TAMPAK DEPAN (PRINT) -->
                <div class="print-card-box">
                    <div class="flex items-center justify-between border-b border-amber-500/40 pb-1.5">
                        <div class="flex items-center space-x-2">
                            <img src="{{ asset('assets/images/logo.webp') }}" alt="Logo IKA" class="h-7 w-auto object-contain">
                            <div>
                                <h3 class="font-heading font-extrabold text-[10px] tracking-tight text-amber-400 leading-none uppercase">
                                    IKA SMAN KAJUARA / SMAN 8 BONE
                                </h3>
                                <span class="text-[7.5px] font-bold tracking-widest uppercase text-slate-300 block mt-0.5">
                                    KARTU TANDA ANGGOTA RESMI
                                </span>
                            </div>
                        </div>
                        <div class="px-2 py-0.5 rounded-full bg-emerald-500/20 border border-emerald-400/40 text-emerald-300 text-[7.5px] font-black tracking-wider uppercase shrink-0">
                            VERIFIED
                        </div>
                    </div>

                    <div class="flex items-center space-x-3 py-1">
                        <!-- Foto Frame Fixed 75px x 92px -->
                        <div class="w-[75px] h-[92px] min-w-[75px] min-h-[92px] rounded-xl p-0.5 bg-gradient-to-b from-amber-400 via-amber-600 to-amber-300 shadow-md overflow-hidden shrink-0">
                            @if($alumni->foto)
                                <img src="{{ asset($alumni->foto) }}" alt="{{ $alumni->nama }}" class="w-full h-full object-cover rounded-[10px]">
                            @else
                                <div class="w-full h-full bg-slate-900 rounded-[10px] flex items-center justify-center text-amber-400 font-heading font-extrabold text-base">
                                    {{ substr($alumni->nama, 0, 2) }}
                                </div>
                            @endif
                        </div>

                        <div class="flex-1 min-w-0 space-y-1">
                            <h2 class="font-heading font-bold text-xs text-white truncate leading-tight">
                                {{ $alumni->nama }}
                            </h2>

                            <div class="inline-block px-2 py-0.5 rounded bg-amber-500/20 border border-amber-400/30 text-amber-300 text-[8.5px] font-extrabold tracking-wider uppercase">
                                Angkatan {{ $alumni->angkatan }}
                            </div>

                            <p class="text-[9.5px] text-slate-300 font-medium truncate">
                                <i class="fa-solid fa-location-dot text-amber-400 mr-1 text-[8px]"></i>
                                Domisili: {{ $alumni->domisili ?? 'Kajuara, Kab. Bone' }}
                            </p>

                            <div class="pt-0.5 border-t border-slate-800 flex items-center justify-between">
                                <span class="text-[7.5px] font-mono text-slate-400 tracking-wider">
                                    KTA: <strong class="text-amber-400 font-bold">KTA-IKA.{{ $alumni->angkatan }}.{{ strtoupper(substr(md5($alumni->id), 0, 5)) }}</strong>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-end justify-between border-t border-amber-500/30 pt-1">
                        <div class="flex items-center space-x-1.5">
                            <div class="p-0.5 bg-white rounded-md shrink-0 border border-slate-200">
                                <img src="{{ $qUri }}" alt="QR Verifikasi" class="w-7 h-7 object-contain rounded">
                            </div>
                            <div>
                                <span class="text-[6.5px] text-slate-300 block leading-tight">Scan Verifikasi</span>
                                <span class="text-[8px] font-extrabold text-amber-400 block tracking-tight">ikasman8bone.id</span>
                            </div>
                        </div>

                        <div class="text-right">
                            <span class="text-[6.5px] uppercase tracking-widest text-slate-400 block">Ketua Umum IKA</span>
                            <span class="text-[8.5px] font-bold text-amber-300 block leading-tight">Dr. H. Andi Akmal Pasluddin, M.M.</span>
                        </div>
                    </div>
                </div>

                <!-- TAMPAK BELAKANG (PRINT) -->
                <div class="print-card-box">
                    <div class="border-b border-amber-500/40 pb-1.5 flex items-center justify-between">
                        <span class="font-heading font-extrabold text-[9.5px] text-amber-400 uppercase tracking-wider">
                            KETENTUAN KARTU ANGGOTA
                        </span>
                        <span class="text-[7.5px] text-slate-400">IKA SMAN KAJUARA / SMAN 8 BONE</span>
                    </div>

                    <div class="space-y-1.5 text-[8.5px] text-slate-300 py-1.5 leading-tight">
                        <p class="flex items-start space-x-1">
                            <span class="text-amber-400 font-bold">1.</span>
                            <span>Kartu ini merupakan identitas resmi anggota Ikatan Alumni SMAN Kajuara / SMAN 8 Bone.</span>
                        </p>
                        <p class="flex items-start space-x-1">
                            <span class="text-amber-400 font-bold">2.</span>
                            <span>Pemegang kartu berhak mendapatkan akses jaringan alumni, program kemitraan, dan kegiatan IKA.</span>
                        </p>
                        <p class="flex items-start space-x-1">
                            <span class="text-amber-400 font-bold">3.</span>
                            <span>Keaslian kartu terjamin secara digital dan dapat diverifikasi via scan QR Code.</span>
                        </p>
                    </div>

                    <div class="border-t border-amber-500/30 pt-1 flex items-end justify-between">
                        <div>
                            <span class="text-[6.5px] text-slate-400 uppercase block">Sekretariat IKA:</span>
                            <span class="text-[7.5px] font-semibold text-slate-200 block">Kajuara, Kab. Bone, Sulawesi Selatan</span>
                        </div>
                        <div class="px-2 py-0.5 rounded bg-amber-500/20 border border-amber-400/30 text-amber-400 text-[7.5px] font-bold uppercase tracking-wider">
                            OFFICIAL MEMBER
                        </div>
                    </div>
                </div>

            </div>
        @endforeach
    </div>
</div>

@push('scripts')
<script>
    function printKtaSelection() {
        var el = document.getElementById('kta-root-container');
        if (el && window.Alpine) {
            var data = window.Alpine.$data(el);
            if (data && typeof data.doPrint === 'function') {
                data.doPrint();
                return;
            }
        }
        window.print();
    }
</script>
@endpush

<!-- Styles for 3D Card Flip & A4 Multi-Card Print Layout -->
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

    #ktaPrintArea {
        display: none;
    }

    /* Dedicated A4 Print Layout for Multiple KTA Cards */
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
            display: block !important;
            position: absolute !important;
            left: 0 !important;
            top: 0 !important;
            width: 100% !important;
            background: #ffffff !important;
            padding: 10mm 5mm !important;
        }

        #ktaPrintArea * {
            visibility: visible !important;
        }

        .print-cards-grid {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            gap: 6mm !important;
        }

        .kta-print-row {
            display: flex !important;
            flex-direction: row !important;
            justify-content: center !important;
            align-items: center !important;
            gap: 6mm !important;
            margin-bottom: 6mm !important;
            page-break-inside: avoid !important;
            break-inside: avoid !important;
        }

        .print-card-box {
            width: 85.6mm !important;
            height: 53.98mm !important;
            min-height: 53.98mm !important;
            box-sizing: border-box !important;
            background-color: #0f172a !important;
            color: #ffffff !important;
            border: 2px solid #d97706 !important;
            border-radius: 12px !important;
            padding: 3.5mm !important;
            display: flex !important;
            flex-direction: column !important;
            justify-content: space-between !important;
            overflow: hidden !important;
            page-break-inside: avoid !important;
            break-inside: avoid !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        .print-card-box img {
            max-width: 100% !important;
            display: block !important;
            visibility: visible !important;
        }

        .print-card-box .text-amber-300,
        .print-card-box .text-amber-400 {
            color: #fbbf24 !important;
        }

        .print-card-box .text-slate-300,
        .print-card-box .text-slate-400 {
            color: #cbd5e1 !important;
        }
    }
</style>
@endsection
