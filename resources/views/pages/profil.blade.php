@extends('layouts.app')

@section('title', 'Profil & Sejarah Organisasi')
@section('meta_description', 'Profil lengkap, Visi & Misi, Sejarah Transformasi SMAN Kajuara menjadi SMAN 8 Bone, Beasiswa, dan AD/ART IKA SMAN Kajuara / IKA SMAN 8 Bone.')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Page Header Banner -->
    <div class="text-center max-w-3xl mx-auto mb-16">
        <span class="text-amber-600 font-semibold text-xs uppercase tracking-wider block mb-2">Mengenal IKA</span>
        <h1 class="font-heading text-3xl sm:text-5xl font-extrabold text-slate-900">Tentang IKA SMAN Kajuara / IKA SMAN 8 Bone</h1>
        <p class="text-slate-600 text-base mt-3 leading-relaxed">
            Sejarah, Visi Misi, serta Anggaran Dasar & Anggaran Rumah Tangga (AD/ART) Organisasi Alumni SMAN Kajuara / SMAN 8 Bone.
        </p>
    </div>

    <!-- Visi & Misi Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-16">
        <!-- Visi Card -->
        <div class="glass-card rounded-3xl p-8 border border-slate-200 relative overflow-hidden bg-white shadow-lg">
            <div class="w-14 h-14 rounded-2xl bg-slate-900 text-white flex items-center justify-center mb-6 shadow-md">
                <i class="fa-solid fa-eye text-2xl text-amber-400"></i>
            </div>
            <span class="text-xs uppercase font-bold text-amber-600 tracking-wider block mb-2">Visi Organisasi (2026 - 2031)</span>
            <h2 class="font-heading font-extrabold text-2xl text-slate-900 mb-4 leading-snug">Visi Utama IKA</h2>
            <p class="text-slate-700 text-base leading-relaxed italic border-l-4 border-amber-500 pl-4 py-1 bg-amber-50/50 rounded-r-xl">
                "Mewujudkan jaringan dan silaturahmi yang solid bersama alumni untuk kemajuan dan citra almamater SMAN Kajuara / SMAN 8 Bone."
            </p>
            <div class="mt-6 flex flex-wrap gap-2 pt-4 border-t border-slate-100">
                <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-800 text-xs font-bold border border-slate-200">#Solid</span>
                <span class="px-3 py-1 rounded-full bg-amber-50 text-amber-800 text-xs font-bold border border-amber-200">#Inovatif</span>
                <span class="px-3 py-1 rounded-full bg-sky-50 text-sky-800 text-xs font-bold border border-sky-200">#Kolaboratif</span>
                <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-800 text-xs font-bold border border-emerald-200">#Berdampak</span>
            </div>
        </div>

        <!-- Misi Card -->
        <div class="glass-card rounded-3xl p-8 border border-slate-200 relative overflow-hidden bg-white shadow-lg">
            <div class="w-14 h-14 rounded-2xl bg-slate-900 text-white flex items-center justify-center mb-6 shadow-md">
                <i class="fa-solid fa-bullseye text-2xl text-sky-400"></i>
            </div>
            <span class="text-xs uppercase font-bold text-sky-600 tracking-wider block mb-2">Panca Misi Strategis</span>
            <h2 class="font-heading font-extrabold text-2xl text-slate-900 mb-4">Misi IKA SMAN Kajuara / IKA SMAN 8 Bone</h2>
            <ul class="space-y-3 text-slate-700 text-xs sm:text-sm font-normal">
                <li class="flex items-start"><i class="fa-solid fa-check-circle text-amber-500 mr-2.5 mt-0.5 text-base shrink-0"></i>Membangun jaringan komunikasi yang kuat dan kekeluargaan antar lintas generasi alumni.</li>
                <li class="flex items-start"><i class="fa-solid fa-check-circle text-amber-500 mr-2.5 mt-0.5 text-base shrink-0"></i>Menjadi mitra strategis sekolah dalam meningkatkan kualitas pendidikan, sarana prasarana, dan motivasi siswa.</li>
                <li class="flex items-start"><i class="fa-solid fa-check-circle text-amber-500 mr-2.5 mt-0.5 text-base shrink-0"></i>Menyelenggarakan program pemberdayaan ekonomi, profesi, dan peningkatan kapasitas alumni.</li>
                <li class="flex items-start"><i class="fa-solid fa-check-circle text-amber-500 mr-2.5 mt-0.5 text-base shrink-0"></i>Mewujudkan kepedulian nyata melalui aksi sosial & pengabdian di Kec. Kajuara, Bone, dan sekitarnya.</li>
                <li class="flex items-start"><i class="fa-solid fa-check-circle text-amber-500 mr-2.5 mt-0.5 text-base shrink-0"></i>Mengelola data alumni secara profesional dan terintegrasi untuk memudahkan kolaborasi.</li>
            </ul>
        </div>
    </div>

    <!-- 🚀 SECTION PROGRAM UNGGULAN LINTAS BIDANG -->
    <div class="mb-20">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-amber-600 font-semibold text-xs uppercase tracking-wider block mb-2">Agenda Prioritas Organisasi</span>
            <h2 class="font-heading font-extrabold text-3xl text-slate-900">7 Program Unggulan IKA</h2>
            <p class="text-slate-600 text-sm mt-2">Program lintas bidang sebagai identitas dan bentuk kontribusi nyata bagi almamater & masyarakat.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Program 1 -->
            <div class="glass-card rounded-2xl p-6 border border-slate-200 bg-white hover:border-amber-500 transition duration-300">
                <div class="w-12 h-12 rounded-xl bg-amber-50 border border-amber-200 text-amber-600 flex items-center justify-center mb-4">
                    <i class="fa-solid fa-hand-holding-heart text-xl"></i>
                </div>
                <h3 class="font-heading font-bold text-lg text-slate-900 mb-2">SASKO (Satu Alumni Satu Kontribusi)</h3>
                <p class="text-xs text-slate-600 leading-relaxed">Gerakan partisipasi setiap alumni melalui ide, tenaga, jejaring, atau donasi bagi kemajuan almamater tercinta.</p>
            </div>

            <!-- Program 2 -->
            <div class="glass-card rounded-2xl p-6 border border-slate-200 bg-white hover:border-amber-500 transition duration-300">
                <div class="w-12 h-12 rounded-xl bg-sky-50 border border-sky-200 text-sky-600 flex items-center justify-center mb-4">
                    <i class="fa-solid fa-chalkboard-user text-xl"></i>
                </div>
                <h3 class="font-heading font-bold text-lg text-slate-900 mb-2">Alumni Mengajar & Menginspirasi</h3>
                <p class="text-xs text-slate-600 leading-relaxed">Menghadirkan alumni dari berbagai profesi untuk berbagi pengalaman, motivasi, dan wawasan karier kepada siswa.</p>
            </div>

            <!-- Program 3 -->
            <div class="glass-card rounded-2xl p-6 border border-slate-200 bg-white hover:border-amber-500 transition duration-300">
                <div class="w-12 h-12 rounded-xl bg-slate-100 border border-slate-200 text-slate-800 flex items-center justify-center mb-4">
                    <i class="fa-solid fa-database text-xl text-amber-500"></i>
                </div>
                <h3 class="font-heading font-bold text-lg text-slate-900 mb-2">Database Alumni Terintegrasi Digital</h3>
                <p class="text-xs text-slate-600 leading-relaxed">Memuat profil lengkap, profesi, keahlian, dan potensi kolaborasi seluruh alumni berbasis platform web modern.</p>
            </div>

            <!-- Program 4 -->
            <div class="glass-card rounded-2xl p-6 border border-slate-200 bg-white hover:border-amber-500 transition duration-300">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-600 flex items-center justify-center mb-4">
                    <i class="fa-solid fa-graduation-cap text-xl"></i>
                </div>
                <h3 class="font-heading font-bold text-lg text-slate-900 mb-2">Beasiswa IKA SMAN Kajuara / IKA SMAN 8 Bone</h3>
                <p class="text-xs text-slate-600 leading-relaxed">Mendukung siswa berprestasi dan siswa dari keluarga kurang mampu agar tetap dapat meraih masa depan gemilang.</p>
            </div>

            <!-- Program 5 -->
            <div class="glass-card rounded-2xl p-6 border border-slate-200 bg-white hover:border-amber-500 transition duration-300">
                <div class="w-12 h-12 rounded-xl bg-purple-50 border border-purple-200 text-purple-600 flex items-center justify-center mb-4">
                    <i class="fa-solid fa-briefcase text-xl"></i>
                </div>
                <h3 class="font-heading font-bold text-lg text-slate-900 mb-2">Career & Business Network Alumni</h3>
                <p class="text-xs text-slate-600 leading-relaxed">Membangun jejaring karier, magang, peluang kerja, serta pengembangan wirausaha dan UMKM antar alumni.</p>
            </div>

            <!-- Program 6 -->
            <div class="glass-card rounded-2xl p-6 border border-slate-200 bg-white hover:border-amber-500 transition duration-300">
                <div class="w-12 h-12 rounded-xl bg-rose-50 border border-rose-200 text-rose-600 flex items-center justify-center mb-4">
                    <i class="fa-solid fa-people-group text-xl"></i>
                </div>
                <h3 class="font-heading font-bold text-lg text-slate-900 mb-2">Reuni Akbar 5 Tahunan</h3>
                <p class="text-xs text-slate-600 leading-relaxed">Momentum tahunan mempererat silaturahmi, evaluasi organisasi, dan penggalangan dukungan bagi kemajuan sekolah.</p>
            </div>
        </div>
    </div>

    <!-- Sejarah Singkat Timeline -->
    <div class="mb-20">
        <h2 class="font-heading font-bold text-2xl text-slate-900 mb-8 text-center">Sejarah Perjalanan IKA</h2>
        <div class="max-w-4xl mx-auto space-y-6">
            <div class="glass-card rounded-2xl p-6 border-l-4 border-l-slate-800">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider block mb-1">Tahun Pendirian Sekolah</span>
                <h3 class="font-heading font-bold text-lg text-slate-900">Pendirian SMA Negeri Kajuara</h3>
                <p class="text-sm text-slate-600 mt-2 leading-relaxed">
                    SMA Negeri Kajuara didirikan sebagai pusat pendidikan unggulan di wilayah Bone Selatan, melahirkan ribuan alumni yang kini berkiprah di berbagai sektor nasional.
                </p>
            </div>
            <div class="glass-card rounded-2xl p-6 border-l-4 border-l-amber-500">
                <span class="text-xs font-bold text-amber-600 uppercase tracking-wider block mb-1">Perubahan Nomenklatur</span>
                <h3 class="font-heading font-bold text-lg text-slate-900">Alih Nama Menjadi SMAN 8 Bone</h3>
                <p class="text-sm text-slate-600 mt-2 leading-relaxed">
                    Sesuai dengan kebijakan pemerintah daerah, sekolah resmi berganti nama menjadi SMA Negeri 8 Bone tanpa menghilangkan identitas sejarah Kajuara.
                </p>
            </div>
            <div class="glass-card rounded-2xl p-6 border-l-4 border-l-sky-500">
                <span class="text-xs font-bold text-sky-600 uppercase tracking-wider block mb-1">Musyawarah Besar 2026</span>
                <h3 class="font-heading font-bold text-lg text-slate-900">Pengukuhan Pengurus Pusat Periode 2026-2031</h3>
                <p class="text-sm text-slate-600 mt-2 leading-relaxed">
                    Pelantikan Pengurus Pusat IKA SMAN Kajuara / IKA SMAN 8 Bone secara terstruktur dengan sistem database digital modern untuk merangkul alumni secara nasional.
                </p>
            </div>
        </div>
    </div>

    <!-- AD & ART Interactive Accordion -->
    <div x-data="{ activeAcc: 1 }" class="max-w-4xl mx-auto">
        <div class="flex items-center justify-between mb-8">
            <h2 class="font-heading font-bold text-2xl text-slate-900">Anggaran Dasar & Rumah Tangga (AD/ART)</h2>
            <a href="#" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-xs font-bold text-slate-800 rounded-xl border border-slate-300">
                <i class="fa-solid fa-file-pdf mr-1.5 text-red-500"></i>Download Dokumen PDF
            </a>
        </div>

        <div class="space-y-4">
            <!-- Accordion 1 -->
            <div class="glass-card rounded-2xl overflow-hidden">
                <button @click="activeAcc = (activeAcc === 1 ? 0 : 1)" class="w-full p-5 text-left flex justify-between items-center font-heading font-bold text-slate-900 hover:text-amber-600">
                    <span>BAB I: Nama, Waktu, dan Kedudukan Organisasi</span>
                    <i class="fa-solid" :class="activeAcc === 1 ? 'fa-chevron-up text-amber-600' : 'fa-chevron-down text-slate-400'"></i>
                </button>
                <div x-show="activeAcc === 1" class="px-5 pb-5 text-sm text-slate-600 border-t border-slate-100 pt-4 leading-relaxed">
                    Organisasi ini bernama Ikatan Alumni SMAN Kajuara / SMAN 8 Bone (disingkat IKA SMAN KAJUARA / IKA SMAN 8 BONE). Didirikan untuk jangka waktu yang tidak ditentukan dan berkedudukan pusat di Kajuara, Kabupaten Bone, Sulawesi Selatan.
                </div>
            </div>

            <!-- Accordion 2 -->
            <div class="glass-card rounded-2xl overflow-hidden">
                <button @click="activeAcc = (activeAcc === 2 ? 0 : 2)" class="w-full p-5 text-left flex justify-between items-center font-heading font-bold text-slate-900 hover:text-amber-600">
                    <span>BAB II: Asas dan Sifat Organisasi</span>
                    <i class="fa-solid" :class="activeAcc === 2 ? 'fa-chevron-up text-amber-600' : 'fa-chevron-down text-slate-400'"></i>
                </button>
                <div x-show="activeAcc === 2" class="px-5 pb-5 text-sm text-slate-600 border-t border-slate-100 pt-4 leading-relaxed">
                    IKA SMAN Kajuara / IKA SMAN 8 Bone berasaskan Pancasila dan Undang-Undang Dasar 1945. Organisasi ini bersifat kekeluargaan, independen, sosial, dan tidak berorientasi pada politik praktis.
                </div>
            </div>

            <!-- Accordion 3 -->
            <div class="glass-card rounded-2xl overflow-hidden">
                <button @click="activeAcc = (activeAcc === 3 ? 0 : 3)" class="w-full p-5 text-left flex justify-between items-center font-heading font-bold text-slate-900 hover:text-amber-600">
                    <span>BAB III: Keanggotaan & Hak Alumni</span>
                    <i class="fa-solid" :class="activeAcc === 3 ? 'fa-chevron-up text-amber-600' : 'fa-chevron-down text-slate-400'"></i>
                </button>
                <div x-show="activeAcc === 3" class="px-5 pb-5 text-sm text-slate-600 border-t border-slate-100 pt-4 leading-relaxed">
                    Anggota IKA SMAN Kajuara / IKA SMAN 8 Bone terdiri dari Anggota Biasa (seluruh lulusan SMAN Kajuara/SMAN 8 Bone) dan Anggota Kehormatan. Setiap anggota berhak mendapatkan informasi, berpartisipasi dalam program organisasi, dan memberikan suara dalam Musyawarah Besar.
                </div>
            </div>iv>
        </div>
    </div>
</div>
@endsection
