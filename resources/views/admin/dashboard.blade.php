@extends('layouts.admin_layout')

@section('title', 'Dasbor Panel Internal')

@section('content')
<div class="space-y-6">
    <!-- 1. Welcome Alert Banner -->
    <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center space-x-3 shadow-sm">
        <div class="w-8 h-8 rounded-full bg-emerald-500 text-white flex items-center justify-center font-bold text-sm shrink-0">
            <i class="fa-solid fa-check"></i>
        </div>
        <span class="font-semibold text-sm">Selamat datang kembali, <strong>{{ Auth::user()->full_name ?? 'Admin' }}</strong></span>
    </div>

    <!-- 2. Main Dashboard Title Card -->
    <div class="p-6 sm:p-8 rounded-3xl bg-gradient-to-r from-indigo-50 via-slate-50 to-white border border-indigo-100 shadow-sm relative overflow-hidden">
        <div class="flex items-center space-x-4 mb-2">
            <div class="w-12 h-12 rounded-2xl bg-rose-600 text-white flex items-center justify-center text-xl shadow-md">
                <i class="fa-solid fa-chart-pie"></i>
            </div>
            <div>
                <h1 class="font-heading font-extrabold text-2xl sm:text-3xl text-slate-900">Dashboard IKA & Kinerja</h1>
                <p class="text-sm text-slate-500">Selamat datang kembali, <strong class="text-slate-800">{{ Auth::user()->full_name ?? 'Admin' }}</strong> • Hari ini: <strong>{{ \Carbon\Carbon::now()->translatedFormat('d M Y') }}</strong></p>
            </div>
        </div>
    </div>

    <!-- 3. Summary Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs uppercase font-bold text-slate-400 tracking-wider">Total Alumni Terdaftar</span>
                <div class="font-heading font-extrabold text-3xl text-slate-900 mt-1">{{ number_format($totalAlumni) }}</div>
                <span class="text-[11px] text-emerald-600 font-semibold mt-1 block"><i class="fa-solid fa-circle-check mr-1"></i>Database Terverifikasi</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-slate-900 text-white flex items-center justify-center text-xl shadow-md">
                <i class="fa-solid fa-user-graduate"></i>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs uppercase font-bold text-slate-400 tracking-wider">Berita & Kegiatan</span>
                <div class="font-heading font-extrabold text-3xl text-slate-900 mt-1">{{ $totalBerita }} Artikel</div>
                <span class="text-[11px] text-amber-600 font-semibold mt-1 block"><i class="fa-solid fa-circle-info mr-1"></i>Halaman Publik</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-amber-500 text-white flex items-center justify-center text-xl shadow-md">
                <i class="fa-solid fa-newspaper"></i>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs uppercase font-bold text-slate-400 tracking-wider">Galeri Dokumentasi</span>
                <div class="font-heading font-extrabold text-3xl text-slate-900 mt-1">{{ $totalGaleri }} Foto</div>
                <span class="text-[11px] text-sky-600 font-semibold mt-1 block"><i class="fa-solid fa-images mr-1"></i>Masonry Lightbox</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-sky-500 text-white flex items-center justify-center text-xl shadow-md">
                <i class="fa-solid fa-images"></i>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs uppercase font-bold text-slate-400 tracking-wider">Pengurus Inti</span>
                <div class="font-heading font-extrabold text-3xl text-slate-900 mt-1">{{ $totalPengurus }} Orang</div>
                <span class="text-[11px] text-purple-600 font-semibold mt-1 block"><i class="fa-solid fa-sitemap mr-1"></i>Periode 2026-2031</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-purple-600 text-white flex items-center justify-center text-xl shadow-md">
                <i class="fa-solid fa-sitemap"></i>
            </div>
        </div>
    </div>

    <!-- 4. Main Table Section matching SIPAKATAU Style -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm">
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 pb-4 border-b border-slate-100 gap-4">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-xl bg-rose-600 text-white flex items-center justify-center">
                    <i class="fa-solid fa-users text-lg"></i>
                </div>
                <h2 class="font-heading font-extrabold text-xl text-slate-900">Daftar Data Alumni Terbaru</h2>
            </div>
            <a href="{{ route('admin.alumni') }}" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-xl shadow-md transition flex items-center justify-center">
                <i class="fa-solid fa-plus mr-1.5"></i>Kelola Full Data Alumni
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-700">
                <thead class="bg-slate-50 text-xs uppercase font-bold text-slate-500 border-b border-slate-200">
                    <tr>
                        <th class="p-3">Nama Lengkap</th>
                        <th class="p-3">Angkatan</th>
                        <th class="p-3">Profesi / Pekerjaan</th>
                        <th class="p-3">Domisili Kota</th>
                        <th class="p-3">No. HP</th>
                        <th class="p-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($recentAlumni as $alm)
                        <tr>
                            <td class="p-3 font-semibold text-slate-900">{{ $alm->nama }}</td>
                            <td class="p-3"><span class="px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-800 text-xs font-bold border border-slate-200">Angkatan {{ $alm->angkatan }}</span></td>
                            <td class="p-3">{{ $alm->profesi ?? '-' }}</td>
                            <td class="p-3">{{ $alm->domisili ?? '-' }}</td>
                            <td class="p-3 font-semibold text-rose-600">{{ $alm->no_hp ?? '-' }}</td>
                            <td class="p-3">
                                <span class="px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 text-[10px] font-bold uppercase">Aktif</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
