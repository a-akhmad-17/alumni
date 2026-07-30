@extends('layouts.app')

@section('title', 'Direktori & Demografi Alumni')
@section('meta_description', 'Direktori Resmi Alumni IKA SMAN Kajuara / IKA SMAN 8 Bone. Cari alumni per angkatan, domisili kota, dan analisis grafik sebaran kategori profesi.')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10" x-data="{ modalOpen: false, modalRegister: false, selectedAlumni: {} }">
    
    @if(session('success'))
        <div class="mb-8 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-sm font-semibold flex items-center space-x-3 shadow-md">
            <i class="fa-solid fa-circle-check text-emerald-600 text-xl"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Header Banner & Action Button -->
    <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <span class="text-amber-600 font-bold text-xs uppercase tracking-widest block mb-1">Database & Demografi</span>
            <h1 class="font-heading text-3xl sm:text-4xl font-extrabold text-slate-900">Direktori Alumni IKA SMAN Kajuara / SMAN 8 Bone</h1>
            <p class="text-slate-600 text-sm mt-1">Cari, analisis demografi, dan terhubung dengan sesama alumni dari berbagai angkatan dan profesi.</p>
        </div>

        <button @click="modalRegister = true" class="px-6 py-3.5 bg-slate-900 hover:bg-slate-800 text-white font-extrabold text-xs uppercase tracking-wider rounded-2xl shadow-xl transition-all duration-300 hover:scale-105 flex items-center justify-center shrink-0 border border-slate-700">
            <i class="fa-solid fa-user-plus mr-2 text-amber-400"></i>Daftar Mandiri Alumni Baru
        </button>
    </div>

    <!-- 📊 GRAFIK ANALYTICS DETAILED DEMOGRAFI ALUMNI -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <!-- Grafik 1: Top Domisili Kota Alumni -->
        <div class="glass-card rounded-3xl p-6 border border-slate-200 bg-white shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-heading font-bold text-base text-slate-900"><i class="fa-solid fa-map-location-dot text-amber-600 mr-2"></i>Top Domisili Kota</h3>
                <span class="text-[11px] px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-600 border border-slate-200">Demografi</span>
            </div>
            <div id="chartDomisili" class="w-full"></div>
        </div>

        <!-- Grafik 2: Distribution per Angkatan -->
        <div class="glass-card rounded-3xl p-6 border border-slate-200 bg-white shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-heading font-bold text-base text-slate-900"><i class="fa-solid fa-graduation-cap text-sky-600 mr-2"></i>Sebaran Angkatan</h3>
                <span class="text-[11px] px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-600 border border-slate-200">Tahun</span>
            </div>
            <div id="chartAngkatanDetail" class="w-full"></div>
        </div>

        <!-- Grafik 3: Rasio Jenis Kelamin Alumni -->
        <div class="glass-card rounded-3xl p-6 border border-slate-200 bg-white shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-heading font-bold text-base text-slate-900"><i class="fa-solid fa-venus-mars text-indigo-600 mr-2"></i>Rasio Jenis Kelamin</h3>
                <span class="text-[11px] px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-600 border border-slate-200">Gender</span>
            </div>
            <div id="chartGender" class="w-full flex items-center justify-center min-h-[220px]"></div>
        </div>
    </div>

    <!-- Search & Filter Form Card -->
    <div class="glass-card rounded-3xl p-6 mb-10 border border-slate-200 bg-white shadow-sm">
        <form action="{{ route('alumni.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            <!-- Search Keyword -->
            <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Pencarian</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                        <i class="fa-solid fa-search"></i>
                    </span>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Nama / Profesi / Kota..." class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:border-slate-800 transition">
                </div>
            </div>

            <!-- Filter Angkatan -->
            <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Angkatan</label>
                <select name="angkatan" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-800 transition">
                    <option value="">Semua Angkatan</option>
                    @foreach($angkatanList as $thn)
                        <option value="{{ $thn }}" {{ request('angkatan') == $thn ? 'selected' : '' }}>Angkatan {{ $thn }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Domisili -->
            <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Domisili</label>
                <select name="domisili" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-800 transition">
                    <option value="">Semua Kota</option>
                    @foreach($domisiliList as $dom)
                        <option value="{{ $dom }}" {{ request('domisili') == $dom ? 'selected' : '' }}>{{ $dom }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Gender -->
            <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Jenis Kelamin</label>
                <select name="gender" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-800 transition">
                    <option value="">Semua Gender</option>
                    <option value="Laki-laki" {{ request('gender') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ request('gender') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            <!-- Filter Actions -->
            <div class="flex items-end space-x-2">
                <button type="submit" class="w-full py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-sm rounded-xl transition shadow-md">
                    <i class="fa-solid fa-filter mr-1.5 text-amber-400"></i>Filter
                </button>
                @if(request()->hasAny(['q', 'angkatan', 'domisili', 'gender']))
                    <a href="{{ route('alumni.index') }}" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold rounded-xl transition flex items-center justify-center border border-slate-300">
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Alumni Card Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
        @forelse($alumniList as $alumni)
            <div class="glass-card rounded-3xl p-6 flex flex-col justify-between group hover:border-slate-400 transition duration-300 bg-white border border-slate-200 shadow-sm">
                <div>
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-14 h-14 rounded-2xl bg-slate-900 text-white p-0.5 shadow-md group-hover:scale-105 transition-transform overflow-hidden">
                            @if($alumni->foto)
                                <img src="{{ asset($alumni->foto) }}" alt="{{ $alumni->nama }}" class="w-full h-full object-cover rounded-[14px]">
                            @else
                                <div class="w-full h-full bg-slate-900 rounded-[14px] flex items-center justify-center text-amber-400 font-heading font-bold text-lg">
                                    {{ substr($alumni->nama, 0, 2) }}
                                </div>
                            @endif
                        </div>
                        <span class="px-3 py-1 rounded-full bg-slate-100 border border-slate-200 text-slate-800 text-xs font-bold">
                            Angkatan {{ $alumni->angkatan }}
                        </span>
                    </div>

                    <h3 class="font-heading font-bold text-lg text-slate-900 group-hover:text-amber-600 transition-colors mb-1">{{ $alumni->nama }}</h3>
                    <p class="text-sm font-medium text-slate-600 mb-3"><i class="fa-solid fa-briefcase mr-1.5 text-amber-600 text-xs"></i>{{ $alumni->profesi ?? 'Alumni SMAN 8 Bone' }}</p>

                    <div class="space-y-1.5 text-xs text-slate-500 border-t border-slate-100 pt-3">
                        <p><i class="fa-solid fa-location-dot w-4 text-slate-400"></i>{{ $alumni->domisili ?? 'Indonesia' }}</p>
                    </div>
                </div>

                <div class="pt-5 mt-4">
                    <button @click="modalOpen = true; selectedAlumni = @js($alumni)" class="w-full py-2.5 bg-slate-100 hover:bg-slate-900 text-slate-800 hover:text-white font-semibold text-xs rounded-xl transition border border-slate-200 flex items-center justify-center">
                        <i class="fa-solid fa-user-gear mr-1.5 text-amber-500"></i>Lihat Detail Profil
                    </button>
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 text-center glass-card rounded-3xl bg-white border border-slate-200">
                <i class="fa-solid fa-users-slash text-4xl text-slate-400 mb-3 block"></i>
                <h3 class="font-heading font-bold text-slate-900 text-lg">Data Alumni Tidak Ditemukan</h3>
                <p class="text-slate-500 text-sm mt-1">Coba ubah kata kunci atau reset filter pencarian Boss.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination Links -->
    <div class="mt-8">
        {{ $alumniList->links() }}
    </div>

    <!-- 📝 MODAL PENDAFTARAN MANDIRI ALUMNI BARU -->
    <div x-show="modalRegister" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/70 backdrop-blur-md p-4 overflow-y-auto" style="display: none;">
        <div @click.away="modalRegister = false" class="bg-white rounded-3xl p-6 sm:p-8 max-w-lg w-full border border-slate-200 shadow-2xl relative my-8">
            <button @click="modalRegister = false" class="absolute top-4 right-4 w-8 h-8 rounded-full bg-slate-100 text-slate-500 hover:text-slate-900 flex items-center justify-center">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <div class="mb-6">
                <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-900 border border-amber-300 text-[10px] font-black uppercase tracking-wider inline-block mb-2">Formulir Pendaftaran Alumni</span>
                <h3 class="font-heading font-extrabold text-xl text-slate-900">Pendaftaran Alumni Baru</h3>
                <p class="text-xs text-slate-500 mt-1">Isi data Boss di bawah ini. Data akan diverifikasi oleh Admin/Koordinator Angkatan sebelum dipublikasikan.</p>
            </div>

            <form action="{{ route('alumni.register') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Lengkap & Gelar *</label>
                        <input type="text" name="nama" required placeholder="Dr. H. Nama Alumni, S.T." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-900">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Jenis Kelamin *</label>
                        <select name="jenis_kelamin" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-900">
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Tahun Angkatan *</label>
                        <input type="number" name="angkatan" required min="1988" max="2026" placeholder="Contoh: 1988 atau 2015" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-900">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Domisili Kota</label>
                        <input type="text" name="domisili" placeholder="Makassar / Jakarta..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-900">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Kategori / Sektor Profesi</label>
                        <select name="kategori_profesi" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-900">
                            <option value="">-- Pilihan Sektor Pekerjaan --</option>
                            <option value="TNI / Polri">TNI / Polri</option>
                            <option value="Tenaga Kesehatan">Tenaga Kesehatan</option>
                            <option value="Akademisi & Pendidik">Akademisi & Pendidik</option>
                            <option value="Hukum & Legal">Hukum & Legal</option>
                            <option value="Politisi & Pemerintahan">Politisi & Pemerintahan</option>
                            <option value="Wiraswasta / Pengusaha">Wiraswasta / Pengusaha</option>
                            <option value="ASN / PNS & Birokrasi">ASN / PNS & Birokrasi</option>
                            <option value="Swasta & BUMN">Swasta & BUMN</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Detail Jabatan / Spesifikasi</label>
                        <input type="text" name="profesi" placeholder="Misal: Dokter Spesialis / CEO..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-900">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">No. WhatsApp / HP</label>
                        <input type="text" name="no_hp" placeholder="08123456789" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-900">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Email (Opsional)</label>
                        <input type="email" name="email" placeholder="alumni@email.com" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-900">
                    </div>
                </div>

                <div class="pt-4 flex justify-end space-x-3 border-t border-slate-100">
                    <button type="button" @click="modalRegister = false" class="px-5 py-2.5 bg-slate-100 text-slate-700 text-sm font-semibold rounded-xl border border-slate-300">Batal</button>
                    <button type="submit" class="px-6 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-extrabold text-sm rounded-xl shadow-md flex items-center">
                        <i class="fa-solid fa-paper-plane mr-2 text-amber-400"></i>Kirim Pendaftaran
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Detail Alumni Modal -->
    <div x-show="modalOpen" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/70 backdrop-blur-md p-4" style="display: none;">
        <div @click.away="modalOpen = false" class="bg-white rounded-3xl p-6 sm:p-8 max-w-lg w-full border border-slate-200 shadow-2xl relative">
            <button @click="modalOpen = false" class="absolute top-4 right-4 w-8 h-8 rounded-full bg-slate-100 text-slate-500 hover:text-slate-900 flex items-center justify-center">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <div class="text-center mb-6">
                <div class="w-20 h-20 rounded-full bg-slate-900 text-white p-0.5 mx-auto mb-3 shadow-md overflow-hidden">
                    <template x-if="selectedAlumni.foto">
                        <img :src="'{{ url('/') }}/' + selectedAlumni.foto.replace('http://localhost/', '').replace('{{ url('/') }}/', '')" class="w-full h-full object-cover rounded-full">
                    </template>
                    <template x-if="!selectedAlumni.foto">
                        <div class="w-full h-full bg-slate-900 rounded-full flex items-center justify-center text-amber-400 font-heading font-bold text-2xl" x-text="selectedAlumni.nama ? selectedAlumni.nama.substring(0, 2) : ''"></div>
                    </template>
                </div>
                <h3 class="font-heading font-bold text-xl text-slate-900" x-text="selectedAlumni.nama"></h3>
                <div class="inline-block px-3 py-1 rounded-full bg-slate-100 text-slate-800 text-xs font-bold border border-slate-200 mt-2">
                    Angkatan <span x-text="selectedAlumni.angkatan"></span>
                </div>
            </div>

            <div class="space-y-3 bg-slate-50 rounded-2xl p-5 border border-slate-200 text-sm">
                <div class="flex justify-between border-b border-slate-200 pb-2">
                    <span class="text-slate-500">Angkatan Kelulusan</span>
                    <span class="font-bold text-slate-900" x-text="'Angkatan ' + selectedAlumni.angkatan"></span>
                </div>
                <div class="flex justify-between border-b border-slate-200 pb-2">
                    <span class="text-slate-500">Sektor Pekerjaan</span>
                    <span class="font-bold text-amber-800" x-text="selectedAlumni.kategori_profesi || '-'"></span>
                </div>
                <div class="flex justify-between border-b border-slate-200 pb-2">
                    <span class="text-slate-500">Profesi / Jabatan</span>
                    <span class="font-semibold text-slate-900" x-text="selectedAlumni.profesi || '-'"></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Domisili Kota</span>
                    <span class="font-semibold text-slate-900" x-text="selectedAlumni.domisili || '-'"></span>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-between">
                <a :href="'{{ route('kta.index') }}?id=' + selectedAlumni.id" class="px-4 py-2.5 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-slate-950 font-extrabold text-xs uppercase tracking-wider rounded-xl shadow-md flex items-center transition">
                    <i class="fa-solid fa-id-card mr-2 text-slate-900"></i>Cetak / Lihat KTA
                </a>
                <button @click="modalOpen = false" class="px-6 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-sm rounded-xl">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // 📊 GRAFIK DOMISILI ALUMNI (Horizontal Bar)
        var optionsDomisili = {
            series: [{
                name: 'Jumlah Alumni',
                data: @json($domisiliChartCounts)
            }],
            chart: {
                type: 'bar',
                height: 250,
                toolbar: { show: false },
                foreColor: '#475569'
            },
            plotOptions: {
                bar: {
                    horizontal: true,
                    borderRadius: 4,
                    barHeight: '50%'
                }
            },
            colors: ['#d97706'],
            dataLabels: { enabled: true },
            xaxis: { categories: @json($domisiliChartLabels) }
        };
        new ApexCharts(document.querySelector("#chartDomisili"), optionsDomisili).render();

        // 📊 GRAFIK DETAILED ANGKATAN (Bar)
        var optionsAngkatanDetail = {
            series: [{
                name: 'Alumni',
                data: @json($angkatanChartCounts)
            }],
            chart: {
                type: 'bar',
                height: 250,
                toolbar: { show: false },
                foreColor: '#475569'
            },
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    columnWidth: '40%'
                }
            },
            colors: ['#0284c7'],
            dataLabels: { enabled: false },
            xaxis: { categories: @json($angkatanChartLabels) }
        };
        new ApexCharts(document.querySelector("#chartAngkatanDetail"), optionsAngkatanDetail).render();

        // 📊 GRAFIK RASIO JENIS KELAMIN (Donut Chart)
        var optionsGender = {
            series: @json($genderChartCounts),
            labels: @json($genderChartLabels),
            chart: {
                type: 'donut',
                height: 250,
                foreColor: '#475569'
            },
            colors: ['#0284c7', '#ec4899', '#f59e0b'],
            legend: {
                position: 'bottom'
            },
            dataLabels: {
                enabled: true,
                formatter: function (val, opts) {
                    return opts.w.config.series[opts.seriesIndex];
                }
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: { width: 280 },
                    legend: { position: 'bottom' }
                }
            }]
        };
        new ApexCharts(document.querySelector("#chartGender"), optionsGender).render();
    });
</script>
@endpush
