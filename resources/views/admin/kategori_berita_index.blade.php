@extends('layouts.admin_layout')

@section('title', 'Manajemen Kategori Berita - Dasbor Internal')

@section('content')
<div class="space-y-6" x-data="{ modalTambah: false, modalEdit: false, editData: {} }">
    <!-- Header Card -->
    <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <span class="text-xs uppercase font-bold text-amber-600 tracking-wider block mb-1">Master Data</span>
            <h1 class="font-heading font-extrabold text-2xl text-slate-900">Kategori Berita & Artikel</h1>
            <p class="text-xs text-slate-500 mt-1">Kelola daftar opsi kategori berita yang tersedia untuk penulisan artikel alumni.</p>
        </div>

        <button @click="modalTambah = true" class="px-6 py-3 bg-slate-900 hover:bg-slate-800 text-white font-bold text-sm rounded-xl shadow-md transition flex items-center justify-center shrink-0">
            <i class="fa-solid fa-plus mr-2 text-amber-400"></i>Tambah Kategori Baru
        </button>
    </div>

    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center space-x-2">
            <i class="fa-solid fa-circle-check text-emerald-600 text-sm"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Data Table Card -->
    <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm">
        <!-- Filter Header Bar -->
        <form method="GET" action="{{ route('admin.kategori-berita') }}" class="mb-6 grid grid-cols-1 sm:grid-cols-12 gap-3">
            <div class="sm:col-span-8 relative">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama kategori..." class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-900 focus:outline-none focus:border-slate-800">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3 text-slate-400 text-xs"></i>
            </div>
            <div class="sm:col-span-4 flex gap-2">
                <button type="submit" class="w-full py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-xl shadow-sm transition">
                    <i class="fa-solid fa-filter mr-1.5 text-amber-400"></i>Filter
                </button>
                @if(request()->filled('q'))
                    <a href="{{ route('admin.kategori-berita') }}" class="px-3 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-bold transition flex items-center justify-center shrink-0" title="Reset Filter">
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>
                @endif
            </div>
        </form>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-700">
                <thead class="bg-slate-50 text-xs uppercase font-bold text-slate-500 border-b border-slate-200">
                    <tr>
                        <th class="p-3">#</th>
                        <th class="p-3">Nama Kategori</th>
                        <th class="p-3">Slug (URL)</th>
                        <th class="p-3">Deskripsi</th>
                        <th class="p-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($kategoriList as $idx => $kat)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="p-3 font-semibold text-xs text-slate-400">{{ $kategoriList->firstItem() + $idx }}</td>
                            <td class="p-3 font-bold text-slate-900 flex items-center">
                                <span class="w-2.5 h-2.5 rounded-full bg-amber-500 mr-2.5"></span>
                                {{ $kat->nama_kategori }}
                            </td>
                            <td class="p-3 text-xs font-mono text-slate-500 bg-slate-50 rounded-lg w-fit">
                                {{ $kat->slug }}
                            </td>
                            <td class="p-3 text-xs text-slate-600 max-w-sm leading-relaxed">
                                {{ $kat->deskripsi ?? '-' }}
                            </td>
                            <td class="p-3 flex items-center justify-center space-x-2">
                                <button @click="editData = @js($kat); modalEdit = true" class="px-3 py-1.5 bg-amber-50 text-amber-700 hover:bg-amber-600 hover:text-white rounded-lg text-xs font-bold transition border border-amber-200 flex items-center">
                                    <i class="fa-solid fa-pen-to-square mr-1"></i> Edit
                                </button>
                                <form action="{{ route('admin.kategori-berita.delete', $kat->id) }}" method="POST" onsubmit="return confirm('Apakah Boss yakin ingin menghapus kategori ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1.5 bg-red-50 text-red-600 hover:bg-red-600 hover:text-white rounded-lg text-xs font-bold transition border border-red-200 flex items-center">
                                        <i class="fa-solid fa-trash mr-1"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-slate-400 italic">Belum ada kategori berita yang ditambahkan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="pt-4">
            {{ $kategoriList->links() }}
        </div>
    </div>

    <!-- Modal Tambah Kategori -->
    <div x-show="modalTambah" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-md p-4 overflow-y-auto" style="display: none;">
        <div @click.away="modalTambah = false" class="bg-white rounded-3xl p-6 sm:p-8 max-w-md w-full border border-slate-200 shadow-2xl relative my-8">
            <button @click="modalTambah = false" class="absolute top-4 right-4 text-slate-400 hover:text-slate-900"><i class="fa-solid fa-xmark text-xl"></i></button>

            <h3 class="font-heading font-extrabold text-xl text-slate-900 mb-6 flex items-center">
                <i class="fa-solid fa-tags text-amber-500 mr-2"></i>Tambah Kategori Berita Baru
            </h3>

            <form action="{{ route('admin.kategori-berita.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Kategori *</label>
                    <input type="text" name="nama_kategori" required placeholder="Contoh: Prestasi Alumni / Pengumuman" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-900">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Deskripsi Kategori</label>
                    <textarea name="deskripsi" rows="3" placeholder="Keterangan cakupan kategori berita..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-900"></textarea>
                </div>

                <div class="pt-4 flex justify-end space-x-3 border-t border-slate-100">
                    <button type="button" @click="modalTambah = false" class="px-5 py-2.5 bg-slate-100 text-slate-700 text-sm font-semibold rounded-xl border border-slate-300">Batal</button>
                    <button type="submit" class="px-6 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-sm rounded-xl shadow-md">
                        <i class="fa-solid fa-save mr-1.5 text-amber-400"></i>Simpan Kategori
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Kategori -->
    <div x-show="modalEdit" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-md p-4 overflow-y-auto" style="display: none;">
        <div @click.away="modalEdit = false" class="bg-white rounded-3xl p-6 sm:p-8 max-w-md w-full border border-slate-200 shadow-2xl relative my-8">
            <button @click="modalEdit = false" class="absolute top-4 right-4 text-slate-400 hover:text-slate-900"><i class="fa-solid fa-xmark text-xl"></i></button>

            <h3 class="font-heading font-extrabold text-xl text-slate-900 mb-6 flex items-center">
                <i class="fa-solid fa-pen-to-square text-amber-500 mr-2"></i>Edit Kategori Berita
            </h3>

            <form :action="'{{ url('/admin/kategori-berita') }}/' + editData.id" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Kategori *</label>
                    <input type="text" name="nama_kategori" x-model="editData.nama_kategori" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-900">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Deskripsi Kategori</label>
                    <textarea name="deskripsi" x-model="editData.deskripsi" rows="3" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-900"></textarea>
                </div>

                <div class="pt-4 flex justify-end space-x-3 border-t border-slate-100">
                    <button type="button" @click="modalEdit = false" class="px-5 py-2.5 bg-slate-100 text-slate-700 text-sm font-semibold rounded-xl border border-slate-300">Batal</button>
                    <button type="submit" class="px-6 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-sm rounded-xl shadow-md">
                        <i class="fa-solid fa-save mr-1.5 text-amber-400"></i>Perbarui Kategori
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
