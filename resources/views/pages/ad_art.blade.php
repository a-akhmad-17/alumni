@extends('layouts.app')

@section('title', 'AD / ART Organisasi - IKA SMAN Kajuara / SMAN 8 Bone')
@section('meta_description', 'Anggaran Dasar dan Anggaran Rumah Tangga (AD/ART) Ikatan Keluarga Alumni SMAN Kajuara / SMAN 8 Bone. Landasan hukum, visi misi, tata kelola, dan makna atribut organisasi.')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10" x-data="{ activeTab: 'ad', pdfModalOpen: false, activePdfUrl: '', activePdfTitle: '' }">

    <!-- Header Banner -->
    <div class="glass-card rounded-3xl p-8 sm:p-12 mb-10 bg-slate-900 text-white relative overflow-hidden shadow-2xl border border-slate-800">
        <div class="absolute -right-10 -bottom-10 w-96 h-96 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -left-10 -top-10 w-96 h-96 bg-sky-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 text-center max-w-4xl mx-auto">
            <span class="px-4 py-1.5 rounded-full bg-amber-400/20 text-amber-300 border border-amber-400/30 text-xs font-black uppercase tracking-wider inline-block mb-4">
                <i class="fa-solid fa-scale-balanced mr-1.5 text-amber-400"></i>Konstitusi & Landasan Organisasi
            </span>
            <h1 class="font-heading text-3xl sm:text-5xl font-extrabold text-white tracking-tight leading-tight">
                Anggaran Dasar & Anggaran Rumah Tangga (AD/ART)
            </h1>
            <p class="text-slate-300 text-sm sm:text-base mt-4 leading-relaxed max-w-2xl mx-auto">
                Pedoman resmi tata kelola, visi misi, hak dan kewajiban anggota, serta struktur kepengurusan Ikatan Keluarga Alumni SMAN Kajuara / SMAN 8 Bone.
            </p>

            <!-- Quick Download & Preview PDF Buttons -->
            <div class="mt-8 flex flex-wrap items-center justify-center gap-3">
                <button @click="pdfModalOpen = true; activePdfUrl = '{{ asset('docs/AD IKA SMAN Kajuara_SMAN 8 Bone.pdf') }}'; activePdfTitle = 'Dokumen Resmi Anggaran Dasar (AD)'" class="px-5 py-3 rounded-2xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-extrabold text-xs uppercase tracking-wider transition shadow-lg flex items-center">
                    <i class="fa-solid fa-file-pdf mr-2 text-base"></i>Pratinjau PDF AD
                </button>
                <button @click="pdfModalOpen = true; activePdfUrl = '{{ asset('docs/ART IKA SMAN KAJUARA_SMAN 8 BONE.pdf') }}'; activePdfTitle = 'Dokumen Resmi Anggaran Rumah Tangga (ART)'" class="px-5 py-3 rounded-2xl bg-sky-600 hover:bg-sky-500 text-white font-extrabold text-xs uppercase tracking-wider transition shadow-lg flex items-center">
                    <i class="fa-solid fa-file-pdf mr-2 text-base"></i>Pratinjau PDF ART
                </button>
                <a href="{{ asset('docs/AD IKA SMAN Kajuara_SMAN 8 Bone.pdf') }}" download class="px-4 py-3 rounded-2xl bg-slate-800 hover:bg-slate-700 text-slate-200 font-bold text-xs transition border border-slate-700 flex items-center">
                    <i class="fa-solid fa-download mr-1.5 text-amber-400"></i>Unduh AD
                </a>
                <a href="{{ asset('docs/ART IKA SMAN KAJUARA_SMAN 8 BONE.pdf') }}" download class="px-4 py-3 rounded-2xl bg-slate-800 hover:bg-slate-700 text-slate-200 font-bold text-xs transition border border-slate-700 flex items-center">
                    <i class="fa-solid fa-download mr-1.5 text-sky-400"></i>Unduh ART
                </a>
            </div>
        </div>
    </div>

    <!-- Tab Switcher Navigation -->
    <div class="flex flex-wrap items-center justify-center gap-2 mb-10 border-b border-slate-200 pb-4">
        <button @click="activeTab = 'ad'" :class="activeTab === 'ad' ? 'bg-slate-900 text-white shadow-md font-bold' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200 font-semibold'" class="px-5 py-2.5 rounded-2xl text-xs sm:text-sm transition flex items-center">
            <i class="fa-solid fa-gavel mr-2 text-amber-400"></i>Anggaran Dasar (AD)
        </button>
        <button @click="activeTab = 'art'" :class="activeTab === 'art' ? 'bg-slate-900 text-white shadow-md font-bold' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200 font-semibold'" class="px-5 py-2.5 rounded-2xl text-xs sm:text-sm transition flex items-center">
            <i class="fa-solid fa-book-open-reader mr-2 text-sky-400"></i>Anggaran Rumah Tangga (ART)
        </button>
        <button @click="activeTab = 'logo'" :class="activeTab === 'logo' ? 'bg-slate-900 text-white shadow-md font-bold' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200 font-semibold'" class="px-5 py-2.5 rounded-2xl text-xs sm:text-sm transition flex items-center">
            <i class="fa-solid fa-shield-halved mr-2 text-emerald-400"></i>Makna Logo & Atribut
        </button>
        <button @click="activeTab = 'tim'" :class="activeTab === 'tim' ? 'bg-slate-900 text-white shadow-md font-bold' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200 font-semibold'" class="px-5 py-2.5 rounded-2xl text-xs sm:text-sm transition flex items-center">
            <i class="fa-solid fa-signature mr-2 text-rose-400"></i>Tim Perumus & Pengesahan
        </button>
    </div>

    <!-- 📜 TAB 1: ANGGARAN DASAR (AD) -->
    <div x-show="activeTab === 'ad'" class="space-y-8">
        
        <!-- Mukaddimah Card -->
        <div class="glass-card rounded-3xl p-6 sm:p-8 bg-white border border-amber-200 shadow-md relative overflow-hidden">
            <div class="absolute top-0 left-0 w-2 h-full bg-amber-500"></div>
            <h3 class="font-heading font-black text-xl text-slate-900 mb-3 flex items-center">
                <i class="fa-solid fa-quote-left text-amber-500 mr-2 text-2xl"></i>MUKADDIMAH
            </h3>
            <p class="text-slate-700 text-sm leading-relaxed mb-4">
                Eksistensi sebuah organisasi profesi maupun sosial kemasyarakatan sangat bergantung pada landasan hukum yang memayunginya, sehingga dibutuhkan Anggaran Dasar dan Anggaran Rumah Tangga sebagai pedoman dalam menjalankan organisasi dan menjamin semangat kebersamaan tersebut tetap terjaga.
            </p>
            <p class="text-slate-700 text-sm leading-relaxed italic bg-amber-50/80 p-4 rounded-2xl border border-amber-200/60">
                "Atas berkat rahmat Tuhan Yang Maha Esa, didorong oleh semangat <strong>'Sipakatau, Sipakalebbi, Sipakainge'</strong> (saling memanusiakan, saling menghargai, dan saling mengingatkan), serta keinginan luhur untuk mempererat tali silaturahmi tanpa memandang angkatan maupun latar belakang, kami para alumni SMAN Kajuara / SMAN 8 Bone menghimpun diri dalam sebuah wadah organisasi."
            </p>
        </div>

        <!-- BAB I s/d BAB XI Grid Accordion -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <!-- BAB I -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition">
                <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-800 text-[10px] font-extrabold uppercase tracking-wider inline-block mb-2">BAB I</span>
                <h4 class="font-heading font-extrabold text-base text-slate-900 mb-3">NAMA, WAKTU & KEDUDUKAN</h4>
                <ul class="space-y-2 text-xs text-slate-700 leading-relaxed">
                    <li><strong class="text-slate-900">Pasal 1:</strong> Bernama <em>Ikatan Keluarga Alumni SMAN Kajuara / SMAN 8 Bone</em> (disingkat IKA SMAN Kajuara/SMAN 8 Bone).</li>
                    <li><strong class="text-slate-900">Pasal 2:</strong> Didirikan di Kajuara, Kabupaten Bone pada tanggal <strong>24 April 2023</strong> melalui musyawarah alumni.</li>
                    <li><strong class="text-slate-900">Pasal 3:</strong> Berkedudukan di Kajuara, Kabupaten Bone.</li>
                </ul>
            </div>

            <!-- BAB II -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition">
                <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-800 text-[10px] font-extrabold uppercase tracking-wider inline-block mb-2">BAB II</span>
                <h4 class="font-heading font-extrabold text-base text-slate-900 mb-3">AZAS DAN SIFAT</h4>
                <ul class="space-y-2 text-xs text-slate-700 leading-relaxed">
                    <li><strong class="text-slate-900">Pasal 4 (1):</strong> Berazaskan <strong>Pancasila</strong> dan <strong>UUD 1945</strong>.</li>
                    <li><strong class="text-slate-900">Pasal 4 (2):</strong> Bersifat <strong>Kekeluargaan</strong>.</li>
                </ul>
            </div>

            <!-- BAB III -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition col-span-full">
                <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-900 text-[10px] font-extrabold uppercase tracking-wider inline-block mb-2">BAB III</span>
                <h4 class="font-heading font-extrabold text-lg text-slate-900 mb-3">VISI, MISI DAN TUJUAN</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="p-4 bg-amber-50 rounded-2xl border border-amber-200">
                        <h5 class="font-bold text-amber-900 text-xs uppercase mb-2"><i class="fa-solid fa-eye mr-1.5"></i>Visi Organisasi (Pasal 5)</h5>
                        <p class="text-xs text-slate-800 leading-relaxed">
                            Mewujudkan jaringan dan silaturahmi yang solid bersama alumni untuk kemajuan dan citra almamater yang unggul, berkarakter menuju era digital dan kemandirian.
                        </p>
                    </div>
                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200">
                        <h5 class="font-bold text-slate-900 text-xs uppercase mb-2"><i class="fa-solid fa-bullseye mr-1.5 text-sky-500"></i>Misi Utama (Pasal 6)</h5>
                        <ol class="list-decimal list-inside space-y-1 text-xs text-slate-700">
                            <li>Membangun jaringan komunikasi kuat & kekeluargaan lintas generasi.</li>
                            <li>Menjadi mitra strategis sekolah dalam meningkatkan kualitas pendidikan & motivasi siswa.</li>
                            <li>Pemberdayaan ekonomi, profesi, & kapasitas seluruh anggota.</li>
                            <li>Kepedulian nyata aksi sosial khususnya di Kec. Kajuara, Bone.</li>
                            <li>Pengelolaan data alumni secara profesional dan terintegrasi digital.</li>
                        </ol>
                    </div>
                </div>
            </div>

            <!-- BAB IV -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition">
                <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-800 text-[10px] font-extrabold uppercase tracking-wider inline-block mb-2">BAB IV</span>
                <h4 class="font-heading font-extrabold text-base text-slate-900 mb-3">KEUANGAN DAN ASET</h4>
                <ul class="space-y-2 text-xs text-slate-700 leading-relaxed">
                    <li>Diperoleh dari iuran anggota, sumbangan tidak mengikat, dan usaha sah.</li>
                    <li>Dikelola secara profesional, akuntabel, inovatif, dan amanah oleh Bendahara Umum.</li>
                    <li>Laporan dibuat secara berkala setiap tahun.</li>
                </ul>
            </div>

            <!-- BAB V & VI -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition">
                <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-800 text-[10px] font-extrabold uppercase tracking-wider inline-block mb-2">BAB V & VI</span>
                <h4 class="font-heading font-extrabold text-base text-slate-900 mb-3">LAMBANG, ATRIBUT & KODE ETIK</h4>
                <ul class="space-y-2 text-xs text-slate-700 leading-relaxed">
                    <li>Lambang SMAN 8 Bone bertuliskan <em>'IKA SMAN Kajuara / SMAN 8 Bone'</em>.</li>
                    <li>Atribut meliputi Bendera, Pataka, Papan Nama, Kop Surat, Stempel, dan Kartu Anggota (KTA).</li>
                    <li>Kode Etik menjaga kaidah & marwah yang ditegakkan oleh Dewan Etik.</li>
                </ul>
            </div>

            <!-- BAB VII & VIII -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition col-span-full">
                <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-800 text-[10px] font-extrabold uppercase tracking-wider inline-block mb-2">BAB VII & VIII</span>
                <h4 class="font-heading font-extrabold text-base text-slate-900 mb-3">KEANGGOTAAN, STRUKTUR & PERMUSYAWARATAN</h4>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs text-slate-700">
                    <div class="p-3 bg-slate-50 rounded-xl">
                        <strong class="block text-slate-900 mb-1">Keanggotaan:</strong>
                        Terdiri dari Anggota Biasa (alumni ijazah/pernah terdaftar) dan Anggota Kehormatan (jasa almamater).
                    </div>
                    <div class="p-3 bg-slate-50 rounded-xl">
                        <strong class="block text-slate-900 mb-1">Permusyawaratan:</strong>
                        Musyawarah Besar (MUBES) di tingkat Pusat, Musyawarah Wilayah (MUSWIL), dan Musyawarah Angkatan.
                    </div>
                    <div class="p-3 bg-slate-50 rounded-xl">
                        <strong class="block text-slate-900 mb-1">Tingkatan Pengurus:</strong>
                        1. Pengurus Pusat (Pusat Kajuara, Bone)<br>
                        2. Pengurus Wilayah (Luar Bone)<br>
                        3. Pengurus Angkatan
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- 📘 TAB 2: ANGGARAN RUMAH TANGGA (ART) -->
    <div x-show="activeTab === 'art'" class="space-y-8">
        
        <div class="glass-card rounded-3xl p-6 sm:p-8 bg-white border border-sky-200 shadow-md relative overflow-hidden">
            <div class="absolute top-0 left-0 w-2 h-full bg-sky-500"></div>
            <h3 class="font-heading font-black text-xl text-slate-900 mb-2 flex items-center">
                <i class="fa-solid fa-book-open text-sky-500 mr-2 text-2xl"></i>PEDOMAN PELAKSANAAN (ART)
            </h3>
            <p class="text-slate-700 text-sm leading-relaxed">
                Anggaran Rumah Tangga (ART) mengatur petunjuk teknis pelaksanaan Anggaran Dasar, merinci hak dan kewajiban anggota, tata cara musyawarah, serta mekanisme kepengurusan.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            
            <!-- Keanggotaan -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm">
                <h4 class="font-heading font-extrabold text-sm text-slate-900 uppercase mb-2 flex items-center">
                    <i class="fa-solid fa-user-check text-amber-500 mr-2"></i>Syarat Keanggotaan
                </h4>
                <p class="text-xs text-slate-600 leading-relaxed mb-3">
                    Memiliki ijazah kelulusan / pernah terdaftar sebagai siswa SMAN Kajuara/SMAN 8 Bone dan memiliki Kartu Tanda Anggota (KTA) resmi.
                </p>
            </div>

            <!-- Hak & Kewajiban -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm">
                <h4 class="font-heading font-extrabold text-sm text-slate-900 uppercase mb-2 flex items-center">
                    <i class="fa-solid fa-hand-holding-hand text-sky-500 mr-2"></i>Hak & Kewajiban
                </h4>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Anggota berhak memilih & dipilih, mengajukan usul, dan aktif dalam kegiatan. Berkewajiban mematuhi AD/ART, menjaga marwah almamater, dan berkontribusi aktif.
                </p>
            </div>

            <!-- Masa Jabatan -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm">
                <h4 class="font-heading font-extrabold text-sm text-slate-900 uppercase mb-2 flex items-center">
                    <i class="fa-solid fa-clock text-emerald-500 mr-2"></i>Masa Jabatan
                </h4>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Pengurus Pusat, Pengurus Wilayah, dan Pengurus Angkatan memiliki periode kepengurusan selama <strong>5 (lima) tahun</strong>.
                </p>
            </div>

            <!-- Musyawarah Besar (MUBES) -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm">
                <h4 class="font-heading font-extrabold text-sm text-slate-900 uppercase mb-2 flex items-center">
                    <i class="fa-solid fa-people-roof text-rose-500 mr-2"></i>Musyawarah Besar (MUBES)
                </h4>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Kekuasaan tertinggi organisasi diadakan 1 (satu) kali dalam 5 tahun. Dianggap sah jika memenuhi kuorum 2/3 jumlah peserta.
                </p>
            </div>

            <!-- MUSLUB -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm">
                <h4 class="font-heading font-extrabold text-sm text-slate-900 uppercase mb-2 flex items-center">
                    <i class="fa-solid fa-bolt text-amber-500 mr-2"></i>Musyawarah Luar Biasa (MUSLUB)
                </h4>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Diselenggarakan jika terjadi pelanggaran AD/ART, tindak pidana, atau berhalangan tetap, atas usulan tertulis 2/3 Dewan Pengurus.
                </p>
            </div>

            <!-- Keuangan -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm">
                <h4 class="font-heading font-extrabold text-sm text-slate-900 uppercase mb-2 flex items-center">
                    <i class="fa-solid fa-wallet text-indigo-500 mr-2"></i>Keuangan & Aset
                </h4>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Semua aset diinventarisir dan dilaporkan berkala. Pembubaran organisasi menghibahkan aset kepada SMAN Kajuara / SMAN 8 Bone.
                </p>
            </div>

        </div>
    </div>

    <!-- 🛡️ TAB 3: MAKNA LOGO & ATRIBUT ORGANISASI -->
    <div x-show="activeTab === 'logo'" class="space-y-8">
        <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-md">
            <div class="flex flex-col lg:flex-row items-center gap-8">
                <!-- Logo Image Display -->
                <div class="w-48 h-48 bg-slate-950 rounded-3xl p-4 border border-slate-800 flex items-center justify-center shrink-0 shadow-xl">
                    <img src="{{ asset('assets/images/logo.webp') }}" alt="Logo IKA SMAN Kajuara / SMAN 8 Bone" class="max-h-full object-contain">
                </div>

                <!-- Explanation List -->
                <div class="space-y-4 flex-grow">
                    <h3 class="font-heading font-black text-2xl text-slate-900 mb-2">Filosofi & Makna Lambang IKA</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs text-slate-700">
                        <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-200">
                            <strong class="text-slate-900 block mb-1 font-bold text-sm"><i class="fa-solid fa-handshake text-amber-500 mr-1.5"></i>Tangan Saling Menggenggam</strong>
                            Persatuan, solidaritas, saling mendukung, membantu, serta kekeluargaan yang erat antar alumni.
                        </div>
                        <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-200">
                            <strong class="text-slate-900 block mb-1 font-bold text-sm"><i class="fa-solid fa-shield text-sky-500 mr-1.5"></i>Perisai (Shield) di Tengah</strong>
                            Perhitungan dan kekuatan; wadah yang saling menjaga dan memperkuat anggotanya.
                        </div>
                        <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-200">
                            <strong class="text-slate-900 block mb-1 font-bold text-sm"><i class="fa-solid fa-book-open text-emerald-500 mr-1.5"></i>Buku Terbuka</strong>
                            Akses terhadap ilmu tanpa batas dan pikiran manusia yang siap menerima ide-ide baru.
                        </div>
                        <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-200">
                            <strong class="text-slate-900 block mb-1 font-bold text-sm"><i class="fa-solid fa-star text-amber-400 mr-1.5"></i>Bintang Kiri & Kanan</strong>
                            Harapan, cita-cita, dan pencapaian tinggi alumni.
                        </div>
                        <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-200 sm:col-span-2">
                            <strong class="text-slate-900 block mb-1 font-bold text-sm"><i class="fa-solid fa-circle text-indigo-500 mr-1.5"></i>Bentuk Lingkaran Kebersamaan</strong>
                            Kesatuan, keabadian, dan kebersamaan tanpa batas yang terus terjalin sepanjang waktu.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ✍️ TAB 4: TIM PERUMUS & PENGESAHAN -->
    <div x-show="activeTab === 'tim'" class="space-y-8">
        <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-md">
            
            <div class="text-center max-w-2xl mx-auto mb-8">
                <span class="px-3.5 py-1 rounded-full bg-emerald-100 text-emerald-900 border border-emerald-300 text-xs font-bold uppercase tracking-wider inline-block mb-2">
                    Disahkan: Kajuara, 30 April 2026 Pukul 23.03 WITA
                </span>
                <h3 class="font-heading font-black text-2xl text-slate-900">Tim Perumus AD / ART</h3>
            </div>

            <!-- Tim Perumus Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
                <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 text-center">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-amber-800 block mb-1">Ketua Tim Perumus</span>
                    <h4 class="font-extrabold text-slate-900 text-sm">TAKDIR KAHAR</h4>
                </div>
                <div class="p-4 rounded-2xl bg-sky-50 border border-sky-200 text-center">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-sky-800 block mb-1">Sekretaris</span>
                    <h4 class="font-extrabold text-slate-900 text-sm">USMAN</h4>
                </div>
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 text-center sm:col-span-2 lg:col-span-1">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500 block mb-1">Ketua Umum IKA</span>
                    <h4 class="font-extrabold text-slate-900 text-sm">DR. H. ANDI AKMALPASLUDDIN, M.M.</h4>
                </div>
            </div>

            <h4 class="font-bold text-xs uppercase tracking-wider text-slate-400 mb-3 text-center">Anggota Tim Perumus Yang Hadir:</h4>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3 text-xs text-slate-800 text-center font-bold">
                <div class="p-2.5 rounded-xl bg-slate-100">DARWIS PAEWAI</div>
                <div class="p-2.5 rounded-xl bg-slate-100">AHMADI</div>
                <div class="p-2.5 rounded-xl bg-slate-100">SUBHAN</div>
                <div class="p-2.5 rounded-xl bg-slate-100">ANDI ABDI PRAWIRANEGARA</div>
                <div class="p-2.5 rounded-xl bg-slate-100">LUKMAN</div>
                <div class="p-2.5 rounded-xl bg-slate-100">HILAL</div>
                <div class="p-2.5 rounded-xl bg-slate-100">AHMAD</div>
                <div class="p-2.5 rounded-xl bg-slate-100">DEDI SUHENDAR</div>
                <div class="p-2.5 rounded-xl bg-slate-100">AYR BANDRONK</div>
                <div class="p-2.5 rounded-xl bg-slate-100">ADZAN ABRAR</div>
            </div>

        </div>
    </div>

    <!-- PDF PREVIEW MODAL (FULLSCREEN VIEWER) -->
    <div x-show="pdfModalOpen" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/90 backdrop-blur-md p-2 sm:p-6 overflow-hidden" style="display: none;">
        <div @click.away="pdfModalOpen = false" class="bg-white rounded-3xl w-full h-full max-w-6xl max-h-[92vh] border border-slate-200 shadow-2xl relative flex flex-col overflow-hidden">
            
            <!-- Modal Header -->
            <div class="p-4 sm:p-5 bg-slate-900 text-white flex items-center justify-between shrink-0">
                <div class="flex items-center space-x-3">
                    <i class="fa-solid fa-file-pdf text-amber-400 text-xl"></i>
                    <h3 class="font-heading font-extrabold text-sm sm:text-base" x-text="activePdfTitle"></h3>
                </div>
                <div class="flex items-center space-x-2">
                    <a :href="activePdfUrl" download class="px-3.5 py-1.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-xs transition">
                        <i class="fa-solid fa-download mr-1"></i>Unduh PDF
                    </a>
                    <button @click="pdfModalOpen = false" class="w-8 h-8 rounded-full bg-slate-800 text-white hover:bg-slate-700 flex items-center justify-center">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            </div>

            <!-- PDF iFrame Container -->
            <div class="flex-grow bg-slate-100 relative">
                <iframe :src="activePdfUrl" class="w-full h-full border-0"></iframe>
            </div>

        </div>
    </div>

</div>
@endsection
