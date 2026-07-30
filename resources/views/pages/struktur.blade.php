@extends('layouts.app')

@section('title', 'Struktur Kepengurusan & Organogram')
@section('meta_description', 'Susunan Pengurus Pusat IKA SMAN Kajuara / IKA SMAN 8 Bone Periode 2026-2031, Organogram visual, dan rincian 8 bidang kerja teknis.')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10" x-data="{ filterKat: 'semua', searchQuery: '', selectedBidang: null, modalBidang: false }">
    <!-- Header Banner -->
    <div class="text-center max-w-3xl mx-auto mb-10">
        <span class="px-3.5 py-1 rounded-full bg-amber-100 text-amber-800 border border-amber-200 font-semibold text-xs uppercase tracking-wider inline-block mb-3">
            <i class="fa-solid fa-award mr-1.5"></i>Periode Kepengurusan 2026 - 2031
        </span>
        <h1 class="font-heading text-3xl sm:text-5xl font-extrabold text-slate-900 tracking-tight">Struktur Organisasi & Direktori Pengurus</h1>
        <p class="text-slate-600 text-base mt-3 leading-relaxed">
            Bagan hirarki terstruktur Pengurus Pusat, 8 Bidang Kerja Teknis, serta Direktori Foto Profil Seluruh Pengurus IKA SMAN Kajuara / SMAN 8 Bone.
        </p>
    </div>

    <!-- SK Banner Download Card -->
    <div class="glass-card rounded-3xl p-6 sm:p-8 mb-12 border border-slate-200 bg-white flex flex-col sm:flex-row items-center justify-between gap-6 shadow-md hover:shadow-lg transition">
        <div class="flex items-center space-x-4">
            <div class="w-14 h-14 rounded-2xl bg-slate-900 text-white flex items-center justify-center shrink-0 shadow-md">
                <i class="fa-solid fa-file-signature text-2xl text-amber-400"></i>
            </div>
            <div>
                <h3 class="font-heading font-bold text-slate-900 text-lg">Surat Keputusan Kepengurusan Pusat</h3>
                <p class="text-xs sm:text-sm text-slate-600 mt-0.5">SK No: 001/SK-PP/IKA-SMAN8/2026 tentang Susunan Pengurus IKA SMAN Kajuara / IKA SMAN 8 Bone</p>
            </div>
        </div>
        <a href="#" class="px-6 py-3 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs sm:text-sm rounded-xl transition shadow-md shrink-0 flex items-center">
            <i class="fa-solid fa-download mr-2 text-amber-400"></i>Unduh SK Resmi PDF
        </a>
    </div>

    <!-- 🌳 SECTION 1: BAGAN HIRARKI ORGANOGRAM TERSTRUKTUR (VISUAL ORGANOGRAM TREE) -->
    <div class="mb-20">
        <div class="text-center mb-10">
            <span class="text-amber-600 font-bold text-xs uppercase tracking-widest block mb-1">Hirarki Kepemimpinan</span>
            <h2 class="font-heading font-extrabold text-2xl sm:text-3xl text-slate-900"><i class="fa-solid fa-sitemap mr-2.5 text-amber-600"></i>Bagan Pengurus Inti</h2>
            <div class="w-16 h-1 bg-slate-900 rounded-full mx-auto mt-3"></div>
        </div>

        @php
            $ketuaUmum = $pengurusInti->firstWhere('jabatan', 'Ketua Umum');
            $ketuaHarian = $pengurusInti->firstWhere('jabatan', 'Ketua Harian');
            $sekum = $pengurusInti->firstWhere('jabatan', 'Sekretaris Umum');
            $wasek = $pengurusInti->firstWhere('jabatan', 'Wakil Sekretaris');
            $bendum = $pengurusInti->firstWhere('jabatan', 'Bendahara Umum');
            $wabendum = $pengurusInti->firstWhere('jabatan', 'Wakil Bendahara');
        @endphp

        <div class="flex flex-col items-center space-y-8 relative">
            <!-- LEVEL 1: KETUA UMUM (TOP NODE) -->
            @if($ketuaUmum)
                <div class="glass-card rounded-3xl p-6 text-center max-w-sm w-full border-2 border-slate-900 shadow-xl relative z-10 bg-white group hover:scale-[1.02] transition duration-300">
                    <div class="w-28 h-28 rounded-full bg-gradient-to-tr from-amber-500 to-slate-900 p-1 mx-auto mb-4 shadow-xl relative">
                        @if($ketuaUmum->foto)
                            <img src="{{ asset($ketuaUmum->foto) }}" alt="{{ $ketuaUmum->nama }}" class="w-full h-full rounded-full object-cover">
                        @else
                            <div class="w-full h-full bg-slate-900 rounded-full flex flex-col items-center justify-center text-white font-bold text-2xl border-2 border-white">
                                <i class="fa-solid fa-user text-amber-400 text-3xl mb-1"></i>
                            </div>
                        @endif
                        <span class="absolute bottom-0 right-0 w-8 h-8 rounded-full bg-amber-500 text-slate-900 flex items-center justify-center text-xs font-black shadow-md border-2 border-white">
                            <i class="fa-solid fa-crown"></i>
                        </span>
                    </div>
                    <span class="px-4 py-1 rounded-full bg-slate-900 text-amber-400 text-xs font-black uppercase tracking-wider inline-block mb-2 shadow-sm border border-slate-800">
                        {{ $ketuaUmum->jabatan }}
                    </span>
                    <h3 class="font-heading font-extrabold text-xl text-slate-900 mb-1">{{ $ketuaUmum->nama }}</h3>
                    <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed px-2 mb-3">{{ $ketuaUmum->deskripsi_tugas ?? 'Memimpin dan mengkoordinasikan seluruh arah kebijakan strategis organisasi IKA SMAN Kajuara / SMAN 8 Bone.' }}</p>
                    
                    <div class="flex justify-center space-x-2 pt-2 border-t border-slate-100">
                        <a href="{{ $ketuaUmum->sosmed_instagram ?? '#' }}" target="_blank" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-900 hover:text-white flex items-center justify-center transition text-xs text-slate-600"><i class="fa-brands fa-instagram"></i></a>
                        <a href="{{ $ketuaUmum->sosmed_linkedin ?? '#' }}" target="_blank" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-900 hover:text-white flex items-center justify-center transition text-xs text-slate-600"><i class="fa-brands fa-linkedin-in"></i></a>
                    </div>
                </div>
            @endif

            <!-- VERTICAL CONNECTOR LINE LEVEL 1 -> LEVEL 2 -->
            <div class="w-0.5 h-8 bg-slate-400"></div>

            <!-- LEVEL 2: KETUA HARIAN, SEKRETARIS UMUM, BENDAHARA UMUM -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 w-full max-w-5xl">
                <!-- KETUA HARIAN -->
                @if($ketuaHarian)
                    <div class="glass-card rounded-2xl p-5 text-center border border-slate-300 shadow-md bg-white hover:border-slate-800 transition duration-300">
                        <div class="w-20 h-20 rounded-full bg-slate-800 p-0.5 mx-auto mb-3 shadow-md relative">
                            @if($ketuaHarian->foto)
                                <img src="{{ asset($ketuaHarian->foto) }}" alt="{{ $ketuaHarian->nama }}" class="w-full h-full rounded-full object-cover">
                            @else
                                <div class="w-full h-full bg-slate-800 rounded-full flex items-center justify-center text-amber-400 font-bold text-xl border-2 border-white">
                                    <i class="fa-solid fa-user-tie"></i>
                                </div>
                            @endif
                        </div>
                        <span class="px-3 py-0.5 rounded-full bg-amber-100 text-amber-900 border border-amber-300 text-[11px] font-bold uppercase inline-block mb-1.5">
                            {{ $ketuaHarian->jabatan }}
                        </span>
                        <h4 class="font-heading font-bold text-base text-slate-900 mb-1">{{ $ketuaHarian->nama }}</h4>
                        <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">{{ $ketuaHarian->deskripsi_tugas ?? 'Membantu Ketua Umum dalam operasional harian kepengurusan.' }}</p>
                    </div>
                @endif

                <!-- SEKRETARIS UMUM -->
                @if($sekum)
                    <div class="glass-card rounded-2xl p-5 text-center border border-slate-300 shadow-md bg-white hover:border-slate-800 transition duration-300">
                        <div class="w-20 h-20 rounded-full bg-slate-800 p-0.5 mx-auto mb-3 shadow-md relative">
                            @if($sekum->foto)
                                <img src="{{ asset($sekum->foto) }}" alt="{{ $sekum->nama }}" class="w-full h-full rounded-full object-cover">
                            @else
                                <div class="w-full h-full bg-slate-800 rounded-full flex items-center justify-center text-sky-400 font-bold text-xl border-2 border-white">
                                    <i class="fa-solid fa-file-pen"></i>
                                </div>
                            @endif
                        </div>
                        <span class="px-3 py-0.5 rounded-full bg-sky-100 text-sky-900 border border-sky-300 text-[11px] font-bold uppercase inline-block mb-1.5">
                            {{ $sekum->jabatan }}
                        </span>
                        <h4 class="font-heading font-bold text-base text-slate-900 mb-1">{{ $sekum->nama }}</h4>
                        <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">{{ $sekum->deskripsi_tugas ?? 'Mengelola administrasi, surat keputusan, dan tata kearsipan organisasi.' }}</p>
                    </div>
                @endif

                <!-- BENDAHARA UMUM -->
                @if($bendum)
                    <div class="glass-card rounded-2xl p-5 text-center border border-slate-300 shadow-md bg-white hover:border-slate-800 transition duration-300">
                        <div class="w-20 h-20 rounded-full bg-slate-800 p-0.5 mx-auto mb-3 shadow-md relative">
                            @if($bendum->foto)
                                <img src="{{ asset($bendum->foto) }}" alt="{{ $bendum->nama }}" class="w-full h-full rounded-full object-cover">
                            @else
                                <div class="w-full h-full bg-slate-800 rounded-full flex items-center justify-center text-emerald-400 font-bold text-xl border-2 border-white">
                                    <i class="fa-solid fa-wallet"></i>
                                </div>
                            @endif
                        </div>
                        <span class="px-3 py-0.5 rounded-full bg-emerald-100 text-emerald-900 border border-emerald-300 text-[11px] font-bold uppercase inline-block mb-1.5">
                            {{ $bendum->jabatan }}
                        </span>
                        <h4 class="font-heading font-bold text-base text-slate-900 mb-1">{{ $bendum->nama }}</h4>
                        <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">{{ $bendum->deskripsi_tugas ?? 'Mengelola tata kelola keuangan, anggaran belanja, dan laporan donasi alumni.' }}</p>
                    </div>
                @endif
            </div>

            <!-- LEVEL 3: WAKIL SEKRETARIS & WAKIL BENDAHARA -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 w-full max-w-2xl">
                @if($wasek)
                    <div class="glass-card rounded-2xl p-4 border border-slate-200 flex items-center space-x-4 bg-white shadow-sm hover:shadow-md transition">
                        <div class="w-14 h-14 rounded-full bg-slate-900 p-0.5 text-white flex items-center justify-center font-bold text-sm shrink-0 shadow-md">
                            @if($wasek->foto)
                                <img src="{{ asset($wasek->foto) }}" alt="{{ $wasek->nama }}" class="w-full h-full rounded-full object-cover">
                            @else
                                <i class="fa-solid fa-user-check text-amber-400 text-lg"></i>
                            @endif
                        </div>
                        <div class="text-left">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500 block">{{ $wasek->jabatan }}</span>
                            <h5 class="font-heading font-bold text-base text-slate-900">{{ $wasek->nama }}</h5>
                        </div>
                    </div>
                @endif

                @if($wabendum)
                    <div class="glass-card rounded-2xl p-4 border border-slate-200 flex items-center space-x-4 bg-white shadow-sm hover:shadow-md transition">
                        <div class="w-14 h-14 rounded-full bg-slate-900 p-0.5 text-white flex items-center justify-center font-bold text-sm shrink-0 shadow-md">
                            @if($wabendum->foto)
                                <img src="{{ asset($wabendum->foto) }}" alt="{{ $wabendum->nama }}" class="w-full h-full rounded-full object-cover">
                            @else
                                <i class="fa-solid fa-coins text-emerald-400 text-lg"></i>
                            @endif
                        </div>
                        <div class="text-left">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500 block">{{ $wabendum->jabatan }}</span>
                            <h5 class="font-heading font-bold text-base text-slate-900">{{ $wabendum->nama }}</h5>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- 👥 SECTION 2: DIREKTORI FOTO & PROFIL SELURUH PENGURUS -->
    <div class="mb-20">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 gap-4 border-b border-slate-200 pb-6">
            <div>
                <span class="text-amber-600 font-bold text-xs uppercase tracking-widest block mb-1">Galeri Personel</span>
                <h2 class="font-heading font-extrabold text-2xl sm:text-3xl text-slate-900">Direktori Profil Pengurus</h2>
                <p class="text-sm text-slate-600 mt-1">Daftar lengkap foto dan profil pengurus IKA SMAN Kajuara / SMAN 8 Bone.</p>
            </div>

            <!-- Filter Categories & Search Bar -->
            <div class="flex flex-wrap items-center gap-2">
                <button @click="filterKat = 'semua'" :class="filterKat === 'semua' ? 'bg-slate-900 text-white shadow-sm' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200'" class="px-4 py-2 rounded-xl text-xs font-bold transition">
                    Semua ({{ $semuaPengurus->count() }})
                </button>
                <button @click="filterKat = 'inti'" :class="filterKat === 'inti' ? 'bg-slate-900 text-white shadow-sm' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200'" class="px-4 py-2 rounded-xl text-xs font-bold transition">
                    Pengurus Inti
                </button>
                <button @click="filterKat = 'bidang'" :class="filterKat === 'bidang' ? 'bg-slate-900 text-white shadow-sm' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200'" class="px-4 py-2 rounded-xl text-xs font-bold transition">
                    Ketua Bidang
                </button>
                <button @click="filterKat = 'koordinator'" :class="filterKat === 'koordinator' ? 'bg-slate-900 text-white shadow-sm' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200'" class="px-4 py-2 rounded-xl text-xs font-bold transition">
                    Koordinator
                </button>
            </div>
        </div>

        <!-- Grid Cards Foto Pengurus -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($semuaPengurus as $p)
                @php
                    $katClass = 'bidang';
                    if($p->is_inti == 1) {
                        $katClass = 'inti';
                    } elseif($p->id_bidang == 9 || str_contains(strtolower($p->jabatan), 'koordinator')) {
                        $katClass = 'koordinator';
                    }
                @endphp
                <div x-show="filterKat === 'semua' || filterKat === '{{ $katClass }}'" class="glass-card rounded-3xl overflow-hidden border border-slate-200 bg-white flex flex-col justify-between hover:shadow-xl hover:border-amber-400 transition duration-300 group">
                    <!-- Photo Container -->
                    <div class="relative h-64 bg-slate-900 overflow-hidden flex items-center justify-center">
                        @if($p->foto)
                            <img src="{{ asset($p->foto) }}" alt="{{ $p->nama }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        @else
                            <!-- Fallback Photo Card Design -->
                            <div class="w-full h-full bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 flex flex-col items-center justify-center p-6 text-center text-white relative">
                                <div class="w-20 h-20 rounded-full bg-amber-500/10 border-2 border-amber-400/30 flex items-center justify-center text-amber-400 font-extrabold text-2xl mb-2 shadow-inner">
                                    {{ substr($p->nama, 0, 2) }}
                                </div>
                                <span class="text-[10px] text-slate-400 uppercase tracking-widest">Foto Belum Diunggah</span>
                            </div>
                        @endif

                        <!-- Badge Jabatan -->
                        <div class="absolute top-3 left-3">
                            @if($p->is_inti == 1)
                                <span class="px-3 py-1 rounded-full bg-amber-500 text-slate-900 font-extrabold text-[10px] uppercase tracking-wider shadow-md">
                                    Pengurus Inti
                                </span>
                            @elseif($p->id_bidang == 9 || str_contains(strtolower($p->jabatan), 'koordinator'))
                                <span class="px-3 py-1 rounded-full bg-sky-500 text-white font-extrabold text-[10px] uppercase tracking-wider shadow-md">
                                    Koordinator
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full bg-slate-900/90 backdrop-blur-md text-white font-extrabold text-[10px] uppercase tracking-wider border border-white/20 shadow-md">
                                    {{ $p->bidang->nama_bidang ?? 'Pengurus Bidang' }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Details Body -->
                    <div class="p-5 flex-grow flex flex-col justify-between">
                        <div>
                            <span class="text-[11px] font-extrabold uppercase text-amber-600 tracking-wider block mb-1">
                                {{ $p->jabatan }}
                            </span>
                            <h3 class="font-heading font-extrabold text-base text-slate-900 leading-snug mb-1">
                                {{ $p->nama }}
                            </h3>
                            <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">
                                {{ $p->deskripsi_tugas ?? ($p->bidang->deskripsi ?? 'Pengurus IKA SMAN Kajuara / SMAN 8 Bone.') }}
                            </p>
                        </div>

                        <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between">
                            <span class="text-[10px] font-semibold text-slate-400">
                                Periode {{ $p->periode ?? '2026-2031' }}
                            </span>
                            <div class="flex space-x-1.5">
                                @if($p->sosmed_instagram)
                                    <a href="{{ $p->sosmed_instagram }}" target="_blank" class="w-7 h-7 rounded-lg bg-slate-100 hover:bg-slate-900 hover:text-white flex items-center justify-center transition text-xs text-slate-600"><i class="fa-brands fa-instagram"></i></a>
                                @endif
                                @if($p->sosmed_linkedin)
                                    <a href="{{ $p->sosmed_linkedin }}" target="_blank" class="w-7 h-7 rounded-lg bg-slate-100 hover:bg-slate-900 hover:text-white flex items-center justify-center transition text-xs text-slate-600"><i class="fa-brands fa-linkedin-in"></i></a>
                                @endif
                                @if(!$p->sosmed_instagram && !$p->sosmed_linkedin)
                                    <span class="w-7 h-7 rounded-lg bg-slate-50 flex items-center justify-center text-[10px] text-slate-400" title="IKA Verified"><i class="fa-solid fa-circle-check text-amber-500"></i></span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- 🛠️ SECTION 3: 8 BIDANG KERJA ORGANISASI (DENGAN TIM PENGURUS & PROGRAM KERJA) -->
    <div class="mb-20">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-amber-600 font-bold text-xs uppercase tracking-widest block mb-1">Program Kerja Teknis</span>
            <h2 class="font-heading font-extrabold text-3xl text-slate-900">8 Bidang Kerja & Personel Penanggung Jawab</h2>
            <p class="text-sm text-slate-600 mt-2">Fokus program dan pengurus teknis yang menahkodai setiap divisi IKA SMAN Kajuara / IKA SMAN 8 Bone.</p>
        </div>

        @php
            $detailBidangInfo = [
                1 => [
                    'nama' => 'Bidang Organisasi & Keanggotaan',
                    'tujuan' => 'Membangun organisasi yang tertata, profesional, dan memiliki sistem administrasi keanggotaan yang kuat.',
                    'icon' => 'fa-sitemap text-amber-500',
                    'langkah' => [
                        'Pendataan Alumni Terpadu' => 'Menyusun format database alumni, mendata seluruh alumni dari angkatan pertama hingga angkatan terbaru, memverifikasi data, dan memperbarui database secara berkala.',
                        'Penyusunan Administrasi' => 'Menyiapkan seluruh perangkat administrasi organisasi (AD/ART, SOP organisasi, Buku pedoman, SK kepengurusan, dan Tata tertib organisasi).',
                        'Penguatan Struktur Organisasi' => 'Konsolidasi pengurus, rapat koordinasi rutin, evaluasi kinerja bidang, dan pengembangan kepemimpinan.',
                        'Musyawarah Alumni' => 'Dilaksanakan secara berkala sebagai forum evaluasi program dan kinerja, pengambilan keputusan strategis, serta penguatan kebersamaan alumni.'
                    ]
                ],
                2 => [
                    'nama' => 'Bidang Komunikasi, Informatika & Kehumasan',
                    'tujuan' => 'Membangun komunikasi yang efektif dan transparan antar alumni, sekolah, dan masyarakat luas.',
                    'icon' => 'fa-globe text-sky-500',
                    'langkah' => [
                        'Website Resmi Alumni' => 'Membangun platform web resmi IKA dengan database alumni online, publikasi kegiatan, profil alumni inspiratif, info loker, info beasiswa, dan portal donasi.',
                        'Media Sosial Alumni' => 'Pengelolaan akun resmi Instagram, Facebook, YouTube, TikTok, Telegram, dan WhatsApp Channel IKA.',
                        'Buletin Alumni' => 'Penerbitan buletin berkala setiap semester berisi kabar alumni, berita sekolah, artikel inspiratif, dan agenda kegiatan.',
                        'Hubungan Kemitraan' => 'Membangun kerja sama dengan Pemerintah, Dunia Usaha, Perguruan Tinggi, Organisasi Profesi, dan Komunitas Sosial.'
                    ]
                ],
                3 => [
                    'nama' => 'Bidang Pengembangan SDM & Pendidikan',
                    'tujuan' => 'Meningkatkan kualitas sumber daya alumni dan memberikan kontribusi bagi kemajuan pendidikan almamater.',
                    'icon' => 'fa-user-graduate text-indigo-500',
                    'langkah' => [
                        'Alumni Mengajar & Seminar' => 'Menghadirkan alumni dari berbagai bidang sebagai narasumber motivasi, karier, kuliah, dan dunia kerja di sekolah.',
                        'Pelatihan Kompetensi' => 'Pelatihan Public Speaking, Leadership, Digital Marketing, Wirausaha, dan Bahasa Inggris.',
                        'Program Beasiswa Alumni' => 'Penggalangan beasiswa untuk siswa berprestasi dan siswa dari keluarga kurang mampu.',
                        'Career Center Alumni' => 'Fasilitas informasi lowongan kerja, pelatihan pembuat CV, simulasi wawancara, magang, dan bursa kerja.'
                    ]
                ],
                4 => [
                    'nama' => 'Bidang Sosial & Pengabdian Masyarakat',
                    'tujuan' => 'Meningkatkan kepedulian sosial alumni bagi almamater, sesama alumni, dan masyarakat luas.',
                    'icon' => 'fa-hand-holding-heart text-rose-500',
                    'langkah' => [
                        'Bakti Sosial Alumni' => 'Donor darah, khitanan massal, pengobatan gratis, pembagian sembako, dan bantuan tanggap bencana.',
                        'Peduli Sesama Alumni' => 'Bantuan untuk alumni yang sakit, musibah meninggal dunia, atau membutuhkan uluran tangan.',
                        'Peduli Pendidikan' => 'Donasi buku, renovasi fisik sekolah, dan penguatan bantuan fasilitas perpustakaan.',
                        'Peduli Lingkungan' => 'Penanaman pohon, aksi bersih pantai, bersih masjid, dan edukasi pengelolaan sampah.'
                    ]
                ],
                5 => [
                    'nama' => 'Bidang Ekonomi Kreatif & Usaha',
                    'tujuan' => 'Mewujudkan kemandirian ekonomi organisasi dan memberdayakan UMKM alumni.',
                    'icon' => 'fa-store text-emerald-500',
                    'langkah' => [
                        'Marketplace Alumni' => 'Wadah promosi dan penjualan produk serta jasa karya alumni SMAN Kajuara / SMAN 8 Bone.',
                        'Koperasi Alumni' => 'Layanan simpan pinjam, permodalan usaha, dan gerakan belanja bersama produk alumni.',
                        'Inkubator Bisnis' => 'Pelatihan wirausaha, pendampingan UMKM, branding usaha, dan digital marketing.',
                        'Merchandise & Fund-Raising' => 'Penjualan merchandise resmi (kaos, jaket, mug, kalender) & sponsorship kegiatan.'
                    ]
                ],
                6 => [
                    'nama' => 'Bidang Advokasi (Hukum & HAM)',
                    'tujuan' => 'Memberikan perlindungan, edukasi, dan pendampingan hukum yang profesional bagi alumni.',
                    'icon' => 'fa-scale-balanced text-purple-500',
                    'langkah' => [
                        'Klinik Konsultasi Hukum Gratis' => 'Layanan konsultasi hukum keluarga, pidana, perdata, dan UU ITE untuk alumni.',
                        'Penyuluhan Hukum' => 'Edukasi kesadaran hukum, UU ITE, perlindungan HAM, dan etika berinternet.',
                        'Pendampingan Hukum Alumni' => 'Pendampingan hukum secara proporsional bekerja sama dengan lembaga advokasi terkait.',
                        'Edukasi Anti Korupsi' => 'Penanaman nilai integritas, transparansi, dan akuntabilitas bagi alumni & generasi muda.'
                    ]
                ],
                7 => [
                    'nama' => 'Bidang Seni & Budaya',
                    'tujuan' => 'Melestarikan budaya lokal Bugis dan mempererat persaudaraan alumni melalui karya seni.',
                    'icon' => 'fa-masks-theater text-amber-600',
                    'langkah' => [
                        'Festival Alumni' => 'Pentas seni (musik, tari, teater, puisi, kuliner tradisional) pada agenda perayaan reuni.',
                        'Pelestarian Budaya Bugis' => 'Edukasi bahasa Bugis, aksara Lontara, permainan tradisional, dan kearifan lokal.',
                        'Malam Keakraban Alumni' => 'Agenda keakraban antar generasi alumni saat reuni akbar.',
                        'Dokumentasi Sejarah Alumni' => 'Penyusunan buku sejarah alumni, pemutaran film dokumenter, dan arsip digital.'
                    ]
                ],
                8 => [
                    'nama' => 'Seksi Koordinator Lintas Angkatan',
                    'tujuan' => 'Menjembatani komunikasi dan jaringan kebersamaan perwakilan alumni dari setiap angkatan (1988–2026).',
                    'icon' => 'fa-users-line text-blue-600',
                    'langkah' => [
                        'Penanggung Jawab Angkatan' => 'Menjadi penghubung informasi resmi pengurus pusat ke alumni tiap angkatan.',
                        'Konsolidasi Reuni Class' => 'Mengkoordinir agenda reuni per angkatan dan penggalangan donasi sekolah.',
                        'Update Data Angkatan' => 'Memastikan data kontak dan profesi teman sejawat angkatan terus terbarui.'
                    ]
                ]
            ];
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($detailBidangInfo as $index => $b)
                @php
                    $bidangDb = $bidangList->firstWhere('urutan', $index);
                    $pengurusBidangThis = $bidangDb ? $bidangDb->pengurus : collect();
                @endphp
                <div class="glass-card rounded-3xl p-6 border border-slate-200 bg-white flex flex-col justify-between hover:shadow-xl hover:border-amber-400 transition duration-300">
                    <div>
                        <div class="flex items-center space-x-3 mb-4">
                            <div class="w-10 h-10 rounded-2xl bg-slate-900 text-white flex items-center justify-center font-bold font-heading text-sm shadow-md shrink-0">
                                {{ $index }}
                            </div>
                            <h3 class="font-heading font-bold text-base text-slate-900 leading-snug">{{ $b['nama'] }}</h3>
                        </div>

                        <p class="text-xs text-slate-600 mb-4 leading-relaxed line-clamp-3 font-normal">{{ $b['tujuan'] }}</p>

                        <!-- Display Personel Foto / Avatars per Bidang -->
                        <div class="bg-slate-50 p-3 rounded-2xl border border-slate-200 mb-4">
                            <span class="text-[10px] font-extrabold uppercase text-slate-500 tracking-wider block mb-2">Penanggung Jawab / Tim:</span>
                            @if($pengurusBidangThis->count() > 0)
                                <div class="space-y-2">
                                    @foreach($pengurusBidangThis as $pBid)
                                        <div class="flex items-center space-x-2.5">
                                            <div class="w-7 h-7 rounded-full bg-slate-900 text-amber-400 flex items-center justify-center font-bold text-[10px] overflow-hidden shrink-0 shadow-sm">
                                                @if($pBid->foto)
                                                    <img src="{{ asset($pBid->foto) }}" class="w-full h-full object-cover">
                                                @else
                                                    {{ substr($pBid->nama, 0, 2) }}
                                                @endif
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <h5 class="font-bold text-xs text-slate-900 truncate">{{ $pBid->nama }}</h5>
                                                <span class="text-[9px] text-amber-700 font-semibold block truncate">{{ $pBid->jabatan }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-[11px] text-slate-400 italic">Tim pengurus bidang siap ditugaskan.</p>
                            @endif
                        </div>

                        <div class="space-y-1.5 pt-2 border-t border-slate-100">
                            <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block mb-1">Program Prioritas:</span>
                            @foreach(array_slice(array_keys($b['langkah']), 0, 2) as $programKey)
                                <div class="text-xs text-slate-700 font-semibold flex items-center">
                                    <i class="fa-solid fa-angle-right text-amber-500 mr-2 text-[10px]"></i>{{ $programKey }}
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="pt-5 mt-4">
                        <button @click="selectedBidang = @js($b); modalBidang = true" class="w-full py-2.5 bg-slate-100 hover:bg-slate-900 text-slate-800 hover:text-white font-bold text-xs rounded-xl transition border border-slate-200 flex items-center justify-center">
                            <i class="fa-solid fa-list-check mr-1.5 text-amber-500"></i>Lihat Detail Program Kerja
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Modal Detail Langkah Kerja Bidang -->
        <div x-show="modalBidang" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-md p-4" style="display: none;">
            <div @click.away="modalBidang = false" class="bg-white rounded-3xl p-6 sm:p-8 max-w-2xl w-full border border-slate-200 shadow-2xl relative max-h-[85vh] flex flex-col">
                <button @click="modalBidang = false" class="absolute top-4 right-4 w-8 h-8 rounded-full bg-slate-100 text-slate-500 hover:text-slate-900 flex items-center justify-center">
                    <i class="fa-solid fa-xmark"></i>
                </button>

                <div class="border-b border-slate-200 pb-4 mb-4 shrink-0">
                    <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-amber-50 text-amber-800 text-xs font-bold border border-amber-200 mb-2">
                        <i class="fa-solid fa-sitemap"></i>
                        <span>Detail Program Kerja</span>
                    </div>
                    <h3 class="font-heading font-extrabold text-xl text-slate-900" x-text="selectedBidang ? selectedBidang.nama : ''"></h3>
                    <p class="text-xs text-slate-500 mt-1 italic" x-text="selectedBidang ? selectedBidang.tujuan : ''"></p>
                </div>

                <div class="overflow-y-auto space-y-4 pr-2">
                    <template x-if="selectedBidang && selectedBidang.langkah">
                        <div class="space-y-4">
                            <template x-for="(detail, judul) in selectedBidang.langkah" :key="judul">
                                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200 space-y-1">
                                    <h4 class="font-heading font-bold text-sm text-slate-900 flex items-center">
                                        <i class="fa-solid fa-circle-check text-amber-500 mr-2 text-xs"></i>
                                        <span x-text="judul"></span>
                                    </h4>
                                    <p class="text-xs text-slate-600 leading-relaxed pl-5 font-normal" x-text="detail"></p>
                                </div>
                            </template>
                        </div>
                    </template>
                </div>

                <div class="mt-6 pt-3 border-t border-slate-200 flex justify-end shrink-0">
                    <button @click="modalBidang = false" class="px-6 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-xl">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
