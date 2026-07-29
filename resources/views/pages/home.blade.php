@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<!-- Hero Section with background.webp Image & Modern Dark Overlay -->
<section class="relative overflow-hidden pt-12 pb-20 lg:pt-20 lg:pb-28 text-white bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset('assets/images/background.webp') }}');">
    <!-- Sleek & Modern Dark Gradient Overlay -->
    <div class="absolute inset-0 bg-gradient-to-b from-slate-950/70 via-slate-900/60 to-slate-950/75 backdrop-blur-[2px]"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center max-w-4xl mx-auto">
            <!-- Tagline Pill -->
            <div class="inline-flex items-center space-x-2 px-4 py-2 rounded-full bg-slate-900/60 backdrop-blur-md border border-white/30 text-white text-xs font-semibold uppercase tracking-wider mb-8 shadow-lg">
                <span class="w-2.5 h-2.5 rounded-full bg-amber-400 animate-pulse"></span>
                <span>Portal Resmi Ikatan Alumni SMAN Kajuara / SMAN 8 Bone</span>
            </div>

            <!-- Main Heading -->
            <h1 class="font-heading text-4xl sm:text-6xl lg:text-7xl font-extrabold tracking-tight text-white leading-none mb-6 drop-shadow-[0_4px_12px_rgba(0,0,0,0.7)]">
                Menjalin Silaturahmi, <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-300 via-yellow-200 to-amber-400">Membangun Masa Depan</span>
            </h1>

            <p class="text-lg sm:text-xl text-slate-100 max-w-2xl mx-auto font-normal leading-relaxed mb-10 drop-shadow-[0_2px_6px_rgba(0,0,0,0.8)]">
                Wadah sinergi, jaringan profesional, dan pengabdian alumni SMAN Kajuara / SMAN 8 Bone di seluruh nusantara.
            </p>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('alumni.index') }}" class="w-full sm:w-auto px-8 py-4 rounded-xl bg-amber-500 hover:bg-amber-600 text-slate-950 font-extrabold text-base shadow-xl transition-all duration-300 hover:scale-105 flex items-center justify-center">
                    <i class="fa-solid fa-search mr-2.5 text-slate-950"></i>Jelajahi Direktori Alumni
                </a>
                <a href="{{ route('profil') }}" class="w-full sm:w-auto px-8 py-4 rounded-xl bg-white/10 hover:bg-white/20 backdrop-blur-md text-white border border-white/30 font-bold text-base shadow-sm transition-all duration-300 flex items-center justify-center">
                    <i class="fa-solid fa-circle-info mr-2.5 text-amber-400"></i>Tentang IKA
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Stats Counter Bar -->
<section class="relative z-20 -mt-8 mb-16" x-data="{ modalSambutan: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
            <!-- Stat 1 -->
            <div class="glass-card rounded-2xl p-6 text-center transform hover:-translate-y-1 transition duration-300 border-l-4 border-l-slate-800 bg-white">
                <div class="w-12 h-12 rounded-xl bg-slate-100 border border-slate-200 text-slate-800 flex items-center justify-center mx-auto mb-3">
                    <i class="fa-solid fa-user-graduate text-xl"></i>
                </div>
                <div class="font-heading font-extrabold text-3xl sm:text-4xl text-slate-900">{{ number_format($totalAlumni) }}</div>
                <div class="text-xs uppercase tracking-wider font-semibold text-slate-500 mt-1">Alumni Terdata</div>
            </div>
            <!-- Stat 2 -->
            <div class="glass-card rounded-2xl p-6 text-center transform hover:-translate-y-1 transition duration-300 border-l-4 border-l-amber-500 bg-white">
                <div class="w-12 h-12 rounded-xl bg-amber-50 border border-amber-200 text-amber-600 flex items-center justify-center mx-auto mb-3">
                    <i class="fa-solid fa-layer-group text-xl"></i>
                </div>
                <div class="font-heading font-extrabold text-3xl sm:text-4xl text-slate-900">{{ $totalAngkatan }}</div>
                <div class="text-xs uppercase tracking-wider font-semibold text-slate-500 mt-1">Lintas Angkatan</div>
            </div>
            <!-- Stat 3 -->
            <div class="glass-card rounded-2xl p-6 text-center transform hover:-translate-y-1 transition duration-300 border-l-4 border-l-sky-500 bg-white">
                <div class="w-12 h-12 rounded-xl bg-sky-50 border border-sky-200 text-sky-600 flex items-center justify-center mx-auto mb-3">
                    <i class="fa-solid fa-newspaper text-xl"></i>
                </div>
                <div class="font-heading font-extrabold text-3xl sm:text-4xl text-slate-900">{{ $totalBerita }}</div>
                <div class="text-xs uppercase tracking-wider font-semibold text-slate-500 mt-1">Kabar & Kegiatan</div>
            </div>
            <!-- Stat 4 -->
            <div class="glass-card rounded-2xl p-6 text-center transform hover:-translate-y-1 transition duration-300 border-l-4 border-l-purple-500 bg-white">
                <div class="w-12 h-12 rounded-xl bg-purple-50 border border-purple-200 text-purple-600 flex items-center justify-center mx-auto mb-3">
                    <i class="fa-solid fa-sitemap text-xl"></i>
                </div>
                <div class="font-heading font-extrabold text-3xl sm:text-4xl text-slate-900">{{ $totalPengurus }}</div>
                <div class="text-xs uppercase tracking-wider font-semibold text-slate-500 mt-1">Pengurus Inti</div>
            </div>
        </div>
    </div>

    <!-- 🎙️ SECTION SAMBUTAN KETUA UMUM IKA SMAN KAJUARA / SMAN 8 BONE -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-16">
        <div class="glass-card rounded-3xl p-6 sm:p-10 border border-slate-200 shadow-xl bg-white relative overflow-hidden">
            <!-- Decorative Accent Circle -->
            <div class="absolute -right-16 -top-16 w-64 h-64 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center relative z-10">
                <!-- Foto Ketua Umum -->
                <div class="lg:col-span-4 text-center">
                    <div class="relative inline-block group">
                        <div class="w-48 h-48 sm:w-56 sm:h-56 rounded-3xl overflow-hidden border-4 border-white shadow-2xl mx-auto bg-slate-900 relative">
                            <img src="{{ asset('assets/images/ketua_ika.webp') }}" alt="Dr. H. Andi Akmal Pasluddin, M.M" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        </div>
                        <div class="absolute -bottom-3 inset-x-0 flex justify-center">
                            <span class="px-4 py-1 rounded-full bg-slate-900 text-amber-400 text-xs font-bold shadow-md border border-slate-700 uppercase tracking-wider whitespace-nowrap">
                                <i class="fa-solid fa-award mr-1"></i>Ketua Umum IKA
                            </span>
                        </div>
                    </div>
                    <div class="mt-6">
                        <h3 class="font-heading font-extrabold text-xl text-slate-900">Dr. H. Andi Akmal Pasluddin, M.M</h3>
                        <p class="text-xs font-semibold text-slate-500 mt-1">Ketua Umum PP IKA SMAN Kajuara / SMAN 8 Bone<br>(Periode 2026–2031)</p>
                    </div>
                </div>

                <!-- Kutipan Sambutan Ringkas -->
                <div class="lg:col-span-8 space-y-4">
                    <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-amber-50 border border-amber-200 text-amber-800 text-xs font-bold uppercase tracking-wider">
                        <i class="fa-solid fa-quote-left text-amber-600"></i>
                        <span>Sambutan Ketua Umum</span>
                    </div>

                    <h2 class="font-heading font-extrabold text-2xl sm:text-3xl text-slate-900 leading-tight">
                        "Bersatu, Bermanfaat, dan Bergerak Bersama untuk Almamater Tercinta"
                    </h2>

                    <div class="text-slate-600 text-sm leading-relaxed space-y-3 font-normal">
                        <p class="italic border-l-4 border-amber-500 pl-4 py-1 text-slate-700 font-medium">
                            "Keberadaan alumni adalah aset tak ternilai bagi almamater tercinta yaitu SMAN Kajuara yang telah bertransformasi menjadi SMAN 8 Bone. Ribuan alumni telah tersebar di berbagai pelosok nusantara dengan beragam latar belakang profesi, karya, dan pengabdian."
                        </p>
                        <p>
                            Di era digital yang bergerak sangat cepat ini, jarak dan waktu tidak boleh lagi menjadi penghalang bagi kita untuk saling terhubung. Oleh karena itu, dengan bangga dan rasa syukur kita menyambut hadirnya <strong>Website Resmi IKA SMAN Kajuara / SMAN 8 Bone</strong>.
                        </p>
                        <p class="font-medium text-slate-800">
                            Mari kita jadikan website ini sebagai sarana untuk mempererat persaudaraan: <span class="text-amber-700 font-bold">“Dari alumni, oleh alumni, dan untuk almamater serta daerah tercinta”</span>.
                        </p>
                    </div>

                    <div class="pt-2 flex flex-wrap items-center gap-4">
                        <button @click="modalSambutan = true" class="px-6 py-3 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs uppercase tracking-wider shadow-md transition-all duration-300 flex items-center">
                            <i class="fa-solid fa-book-open mr-2 text-amber-400"></i>Baca Sambutan Lengkap
                        </button>
                        <span class="text-xs text-slate-400 font-medium"><i class="fa-solid fa-location-dot mr-1"></i>Kajuara, 1 Agustus 2026</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Sambutan Lengkap Dokter H. Andi Akmal Pasluddin -->
    <div x-show="modalSambutan" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-md p-4" style="display: none;">
        <div @click.away="modalSambutan = false" class="bg-white rounded-3xl p-6 sm:p-8 max-w-2xl w-full border border-slate-200 shadow-2xl relative max-h-[85vh] flex flex-col">
            <!-- Modal Header -->
            <div class="flex items-center justify-between border-b border-slate-200 pb-4 mb-4 shrink-0">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('assets/images/ketua_ika.webp') }}" alt="Ketua IKA" class="w-10 h-10 rounded-full object-cover border border-amber-500 shadow-sm">
                    <div>
                        <h4 class="font-heading font-bold text-slate-900 text-base">Sambutan Ketua Umum PP IKA</h4>
                        <p class="text-xs text-slate-500">Dr. H. Andi Akmal Pasluddin, M.M (Periode 2026–2031)</p>
                    </div>
                </div>
                <button @click="modalSambutan = false" class="w-8 h-8 rounded-full bg-slate-100 text-slate-500 hover:text-slate-900 flex items-center justify-center">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <!-- Modal Scrollable Content -->
            <div class="overflow-y-auto space-y-4 text-sm text-slate-700 leading-relaxed pr-2 font-normal">
                <div class="p-3 bg-amber-50 border border-amber-200 rounded-xl text-amber-900 font-semibold text-xs text-center">
                    Bismillahi Rahmanirrahim. Assalamu Alaikum Warahmatullahi Wabarakatuh.
                </div>
                <p>
                    Puji dan syukur marilah kita panjatkan ke hadirat Allah SWT, Tuhan Yang Maha Esa, karena atas rahmat dan karunia-Nya, kita semua masih diberikan kesehatan, kekuatan, serta kebersamaan untuk terus menjaga tali silaturahmi antaralumni.
                </p>
                <p>
                    Salawat serta salam tercurah kepada Nabiullah Muhammad SAW yang merupakan penerang di tengah gulita, penyejuk di kala dahaga. Kepada keluarga beliau yang suci, para sahabat yang setia, dan semoga syafaatnya mengalir hingga ke kita, umatnya yang merindukannya di akhir zaman.
                </p>
                <p>
                    Keberadaan alumni adalah aset tak ternilai bagi almamater tercinta yaitu SMAN Kajuara yang telah bertransformasi menjadi SMAN 8 Bone. Kita menyadari betul bahwa ribuan alumni telah tersebar di berbagai pelosok nusantara dengan beragam latar belakang profesi, karya, dan pengabdian.
                </p>
                <p>
                    Di era digital yang bergerak sangat cepat ini, jarak dan waktu tidak boleh lagi menjadi penghalang bagi kita untuk saling terhubung. Oleh karena itu, dengan bangga dan rasa syukur kita menyambut hadirnya <strong>Website Resmi IKA SMAN Kajuara / SMAN 8 Bone</strong>.
                </p>
                <p class="p-4 bg-slate-50 border-l-4 border-amber-500 rounded-r-xl font-medium text-slate-800">
                    Mari kita jadikan website ini sebagai sarana untuk mempererat persaudaraan, merekatkan ikatan kekeluargaan, serta memperkuat kontribusi kita: <em>“Dari alumni, oleh alumni, dan untuk almamater serta daerah tercinta”</em>.
                </p>
                <p>
                    Saya mengucapkan terima kasih yang sebesar-besarnya dan apresiasi yang setinggi-tingginya kepada Tim Perumus, Pengurus, serta seluruh Alumni yang telah bekerja keras hingga website resmi ini dapat terealisasi dengan baik.
                </p>
                <p>
                    Semoga langkah kecil ini menjadi awal dari lompatan besar bagi organisasi IKA SMAN Kajuara / SMAN 8 Bone ke depan.
                </p>
                <div class="text-center font-heading font-extrabold text-lg text-slate-900 py-2">
                    Bersatu, Bermanfaat, dan Bergerak Bersama!
                </div>
                <div class="text-right text-xs text-slate-500 pt-4 border-t border-slate-200">
                    <p>Billahit taufiq wal hidayah,</p>
                    <p>Wassalamu’alaikum Warahmatullahi Wabarakatuh.</p>
                    <p class="mt-3 font-semibold text-slate-800">Kajuara, 1 Agustus 2026</p>
                    <p class="font-bold text-slate-900 mt-1">Dr. H. Andi Akmal Pasluddin, M.M</p>
                    <p class="text-[11px] text-slate-500">Ketua Umum PP IKA SMAN Kajuara / SMAN 8 Bone (2026–2031)</p>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="mt-4 pt-3 border-t border-slate-200 flex justify-end shrink-0">
                <button @click="modalSambutan = false" class="px-6 py-2 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-xl">Tutup</button>
            </div>
        </div>
    </div>
</section>

<!-- SECTION ANALYTICS: 3 MACAM GRAFIK INTERAKTIF -->
<section class="py-12 bg-slate-100/70 border-y border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-amber-600 font-semibold text-xs uppercase tracking-wider block mb-2">Analytics & Demografi</span>
            <h2 class="font-heading font-bold text-3xl text-slate-900">Statistik & Trend Alumni</h2>
            <p class="text-sm text-slate-600 mt-2">Visualisasi data sebaran profesi, angkatan, serta grafik pertumbuhan alumni secara *real-time*.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Grafik 1: Donut Chart Sebaran Profesi -->
            <div class="lg:col-span-4 glass-card rounded-3xl p-6 border border-slate-200 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-heading font-bold text-lg text-slate-900"><i class="fa-solid fa-chart-pie text-amber-500 mr-2"></i>Profesi Alumni</h3>
                        <span class="text-[11px] px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-600 border border-slate-200">Persentase</span>
                    </div>
                    <div id="chartProfesi" class="w-full"></div>
                </div>
                <p class="text-xs text-slate-500 text-center mt-4 pt-3 border-t border-slate-100">
                    Sebaran kategori profesi utama alumni SMAN Kajuara / SMAN 8 Bone.
                </p>
            </div>

            <!-- Grafik 2: Column Chart Sebaran Angkatan -->
            <div class="lg:col-span-4 glass-card rounded-3xl p-6 border border-slate-200 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-heading font-bold text-lg text-slate-900"><i class="fa-solid fa-chart-column text-slate-700 mr-2"></i>Sebaran per Dekade</h3>
                        <span class="text-[11px] px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-600 border border-slate-200">Angkatan</span>
                    </div>
                    <div id="chartAngkatan" class="w-full"></div>
                </div>
                <p class="text-xs text-slate-500 text-center mt-4 pt-3 border-t border-slate-100">
                    Jumlah alumni terdaftar berdasarkan rentang tahun kelulusan.
                </p>
            </div>

            <!-- Grafik 3: Area Spline Chart Trend Keaktifan -->
            <div class="lg:col-span-4 glass-card rounded-3xl p-6 border border-slate-200 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-heading font-bold text-lg text-slate-900"><i class="fa-solid fa-chart-line text-sky-600 mr-2"></i>Trend Pertumbuhan</h3>
                        <span class="text-[11px] px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-600 border border-slate-200">Bulanan</span>
                    </div>
                    <div id="chartTrend" class="w-full"></div>
                </div>
                <p class="text-xs text-slate-500 text-center mt-4 pt-3 border-t border-slate-100">
                    Perkembangan data alumni terverifikasi & agenda kegiatan IKA.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Highlight Berita Section -->
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-10">
            <div>
                <span class="text-slate-500 font-semibold text-xs uppercase tracking-wider block mb-2">Kabar Terbaru</span>
                <h2 class="font-heading font-bold text-3xl sm:text-4xl text-slate-900">Kegiatan & Berita Alumni</h2>
            </div>
            <a href="{{ route('berita.index') }}" class="mt-4 md:mt-0 inline-flex items-center text-sm font-bold text-slate-900 hover:text-amber-600">
                Lihat Semua Berita <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($beritaHighlights as $berita)
                <article class="glass-card rounded-2xl overflow-hidden flex flex-col group border border-slate-200 hover:border-slate-400 transition">
                    <div class="relative h-48 overflow-hidden">
                        <img src="{{ $berita->gambar }}" alt="{{ $berita->judul }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-md px-3 py-1 rounded-full text-xs font-semibold text-slate-900 border border-slate-200 shadow-sm">
                            {{ $berita->penulis }}
                        </div>
                    </div>
                    <div class="p-6 flex-grow flex flex-col justify-between">
                        <div>
                            <div class="text-xs text-slate-500 mb-2">
                                <i class="fa-regular fa-calendar mr-1.5"></i>{{ \Carbon\Carbon::parse($berita->created_at)->format('d M Y') }}
                            </div>
                            <h3 class="font-heading font-bold text-lg text-slate-900 group-hover:text-amber-600 transition-colors line-clamp-2 mb-3">
                                <a href="{{ route('berita.detail', $berita->slug) }}">{{ $berita->judul }}</a>
                            </h3>
                            <p class="text-sm text-slate-600 line-clamp-3 leading-relaxed">
                                {{ $berita->ringkasan }}
                            </p>
                        </div>
                        <div class="pt-5 mt-4 border-t border-slate-100">
                            <a href="{{ route('berita.detail', $berita->slug) }}" class="text-xs font-bold text-slate-800 hover:text-amber-600 uppercase tracking-wider flex items-center">
                                Baca Selengkapnya <i class="fa-solid fa-chevron-right ml-1 text-[10px]"></i>
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

<!-- Alumni Spotlight Cards -->
<section class="py-16 bg-slate-100/60 border-t border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-amber-600 font-semibold text-xs uppercase tracking-wider block mb-2">Inspirasi Alumni</span>
            <h2 class="font-heading font-bold text-3xl text-slate-900">Alumni Berprestasi</h2>
            <p class="text-sm text-slate-600 mt-2">Mengenal lebih dekat kiprah para alumni SMAN Kajuara / SMAN 8 Bone di berbagai penjuru nusantara.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($alumniHighlights as $alumni)
                <div class="glass-card rounded-3xl p-6 text-center group hover:border-amber-400 transition duration-300 bg-white border border-slate-200 shadow-md relative overflow-hidden">
                    @if($alumni->is_berprestasi)
                        <div class="absolute top-0 right-0 bg-amber-500 text-slate-950 font-black text-[9px] uppercase px-3 py-1 rounded-bl-xl shadow-sm">
                            <i class="fa-solid fa-star mr-1"></i>Featured
                        </div>
                    @endif

                    <div class="w-24 h-24 rounded-full bg-gradient-to-tr from-slate-900 to-slate-800 p-1 mx-auto mb-4 group-hover:scale-105 transition-transform shadow-lg relative">
                        @if($alumni->foto)
                            <img src="{{ asset($alumni->foto) }}" alt="{{ $alumni->nama }}" class="w-full h-full object-cover rounded-full">
                        @else
                            <div class="w-full h-full bg-slate-900 rounded-full flex items-center justify-center text-amber-400 font-heading font-extrabold text-xl uppercase border-2 border-white">
                                {{ substr($alumni->nama, 0, 2) }}
                            </div>
                        @endif
                    </div>
                    <h3 class="font-heading font-extrabold text-slate-900 text-base group-hover:text-amber-600 transition-colors">{{ $alumni->nama }}</h3>
                    <div class="inline-block px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-800 text-[11px] font-bold my-2 border border-slate-200">
                        Angkatan {{ $alumni->angkatan }}
                    </div>
                    <p class="text-xs text-slate-800 font-bold truncate mb-1">{{ $alumni->profesi ?? 'Alumni SMAN 8 Bone' }}</p>
                    
                    @if($alumni->deskripsi_prestasi)
                        <p class="text-[11px] text-amber-700 font-semibold line-clamp-2 px-2 my-1 bg-amber-50 py-1 rounded-lg border border-amber-200">
                            <i class="fa-solid fa-award mr-1"></i>{{ $alumni->deskripsi_prestasi }}
                        </p>
                    @endif
                    
                    <p class="text-xs text-slate-400 mt-2"><i class="fa-solid fa-location-dot mr-1"></i>{{ $alumni->domisili ?? 'Indonesia' }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {

        // 📊 GRAFIK 1: Donut Chart Profesi
        var optionsProfesi = {
            series: @json($profesiCounts),
            labels: @json($profesiLabels),
            chart: {
                type: 'donut',
                height: 290,
                foreColor: '#475569'
            },
            colors: ['#1e293b', '#d97706', '#0284c7', '#7c3aed', '#059669', '#dc2626'],
            stroke: { show: false },
            legend: { position: 'bottom', fontSize: '12px' },
            dataLabels: { enabled: true },
            plotOptions: {
                pie: {
                    donut: {
                        size: '65%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: 'Profesi',
                                color: '#0f172a'
                            }
                        }
                    }
                }
            }
        };
        new ApexCharts(document.querySelector("#chartProfesi"), optionsProfesi).render();


        // 📊 GRAFIK 2: Column Chart Angkatan per Dekade
        var optionsAngkatan = {
            series: [{
                name: 'Jumlah Alumni',
                data: @json($dekadeCounts)
            }],
            chart: {
                type: 'bar',
                height: 290,
                toolbar: { show: false },
                foreColor: '#475569'
            },
            plotOptions: {
                bar: {
                    borderRadius: 6,
                    columnWidth: '45%',
                    distributed: true
                }
            },
            dataLabels: { enabled: false },
            xaxis: {
                categories: @json($dekadeLabels),
                labels: { style: { fontSize: '11px' } }
            },
            yaxis: { title: { text: 'Alumni' } },
            colors: ['#334155', '#d97706', '#0284c7', '#6b21a8'],
            legend: { show: false }
        };
        new ApexCharts(document.querySelector("#chartAngkatan"), optionsAngkatan).render();


        // 📊 GRAFIK 3: Spline Area Chart Trend Pertumbuhan
        var optionsTrend = {
            series: [{
                name: 'Registrasi Alumni',
                data: @json($trendRegistrasi)
            }, {
                name: 'Kegiatan / Berita',
                data: @json($trendKegiatan)
            }],
            chart: {
                type: 'area',
                height: 290,
                toolbar: { show: false },
                foreColor: '#475569'
            },
            colors: ['#0f172a', '#d97706'],
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth', width: 2 },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.35,
                    opacityTo: 0.05
                }
            },
            xaxis: { categories: @json($trendMonths) },
            legend: { position: 'bottom', fontSize: '12px' }
        };
        new ApexCharts(document.querySelector("#chartTrend"), optionsTrend).render();

    });
</script>
@endpush
