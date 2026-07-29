@extends('layouts.admin_layout')

@section('title', 'Manajemen Galeri & Video - Dasbor Internal')

@section('content')
<div class="space-y-6" x-data="{
    modalTambah: false,
    modalEdit: false,
    modalKelolaFoto: false,
    selectedAlbumTitle: '',
    selectedAlbumItems: [],
    editData: {},
    mediaType: 'foto',
    openKelolaModal(title, items) {
        this.modalEdit = false;
        this.modalTambah = false;
        this.selectedAlbumTitle = title;
        this.selectedAlbumItems = items;
        this.modalKelolaFoto = true;
    },
    openEditModal(item) {
        this.modalKelolaFoto = false;
        this.modalTambah = false;
        this.editData = item;
        this.modalEdit = true;
    }
}">
    <!-- Header Card -->
    <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <span class="text-xs uppercase font-bold text-amber-600 tracking-wider block mb-1">Manajemen Halaman Publik</span>
            <h1 class="font-heading font-extrabold text-2xl text-slate-900">Galeri Foto & Video Dokumentasi</h1>
            <p class="text-xs text-slate-500 mt-1">Upload album foto kegiatan, kelola foto dokumentasi, dan tautan video dokumentasi kegiatan alumni.</p>
        </div>

        <button @click="modalEdit = false; modalKelolaFoto = false; modalTambah = true" class="px-6 py-3 bg-slate-900 hover:bg-slate-800 text-white font-bold text-sm rounded-xl shadow-md transition flex items-center justify-center shrink-0">
            <i class="fa-solid fa-cloud-arrow-up mr-2 text-amber-400"></i>Tambah Album / Video Baru
        </button>
    </div>

    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center space-x-2">
            <i class="fa-solid fa-circle-check text-emerald-600 text-sm"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Filter Header Bar -->
    <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm">
        <form method="GET" action="{{ route('admin.galeri') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <div class="sm:col-span-6 relative">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama kegiatan atau deskripsi..." class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-900 focus:outline-none focus:border-slate-800">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3 text-slate-400 text-xs"></i>
            </div>
            <div class="sm:col-span-3">
                <select name="kategori" onchange="this.form.submit()" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs font-semibold text-slate-700 focus:outline-none focus:border-slate-800">
                    <option value="semua" {{ request('kategori') == 'semua' ? 'selected' : '' }}>Semua Kategori</option>
                    <option value="Reuni" {{ request('kategori') == 'Reuni' ? 'selected' : '' }}>Reuni</option>
                    <option value="Beasiswa" {{ request('kategori') == 'Beasiswa' ? 'selected' : '' }}>Beasiswa</option>
                    <option value="Bakti Sosial" {{ request('kategori') == 'Bakti Sosial' ? 'selected' : '' }}>Bakti Sosial</option>
                    <option value="Rapat" {{ request('kategori') == 'Rapat' ? 'selected' : '' }}>Rapat Kerja</option>
                    <option value="Olahraga & Seni" {{ request('kategori') == 'Olahraga & Seni' ? 'selected' : '' }}>Olahraga & Seni</option>
                </select>
            </div>
            <div class="sm:col-span-3 flex gap-2">
                <select name="tipe" onchange="this.form.submit()" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs font-semibold text-slate-700 focus:outline-none focus:border-slate-800">
                    <option value="semua" {{ request('tipe') == 'semua' ? 'selected' : '' }}>Semua Tipe Media</option>
                    <option value="foto" {{ request('tipe') == 'foto' ? 'selected' : '' }}>Album Foto</option>
                    <option value="video" {{ request('tipe') == 'video' ? 'selected' : '' }}>Video Dokumentasi</option>
                </select>
                @if(request()->hasAny(['q', 'kategori', 'tipe']))
                    <a href="{{ route('admin.galeri') }}" class="px-3 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-bold transition flex items-center justify-center shrink-0" title="Reset Filter">
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Photo Album Grid (Grouped by Activity Title) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($groupedAlbums as $judul => $items)
            @php
                $coverItem = $items->where('is_cover', 1)->first() ?? $items->first();
                $totalFoto = $items->count();
                $itemsArray = $items->map(function($i) {
                    return [
                        'id' => (string) $i->id,
                        'judul' => (string) $i->judul,
                        'gambar' => (string) $i->gambar,
                        'is_cover' => (int) $i->is_cover,
                        'tipe' => (string) $i->tipe,
                    ];
                })->values()->toArray();
            @endphp
            <div class="bg-white rounded-2xl overflow-hidden flex flex-col justify-between border border-slate-200 shadow-sm hover:shadow-md transition">
                <div class="h-48 relative bg-slate-900 flex items-center justify-center overflow-hidden">
                    @if($coverItem->gambar)
                        <img src="{{ str_starts_with($coverItem->gambar, 'http') ? $coverItem->gambar : asset($coverItem->gambar) }}" alt="{{ $judul }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-slate-900 flex flex-col items-center justify-center text-amber-400 p-4 text-center">
                            <i class="fa-solid fa-video text-3xl mb-1"></i>
                            <span class="text-[10px] text-slate-300 font-bold">Video Dokumentasi</span>
                        </div>
                    @endif

                    <div class="absolute top-2 left-2 flex items-center space-x-1">
                        <span class="px-2.5 py-0.5 rounded-full bg-slate-900/80 backdrop-blur-md text-white text-[10px] font-bold">
                            {{ $coverItem->kategori }}
                        </span>
                        @if($coverItem->tipe == 'video')
                            <span class="px-2.5 py-0.5 rounded-full bg-rose-600 text-white text-[10px] font-bold flex items-center">
                                <i class="fa-solid fa-play mr-1"></i>Video
                            </span>
                        @else
                            <span class="px-2.5 py-0.5 rounded-full bg-amber-500 text-slate-900 text-[10px] font-extrabold uppercase shadow-sm">
                                <i class="fa-solid fa-images mr-1"></i>{{ $totalFoto }} Foto
                            </span>
                        @endif
                    </div>
                </div>

                <div class="p-5 flex-grow flex flex-col justify-between">
                    <div>
                        <h4 class="font-heading font-bold text-slate-900 text-base line-clamp-1 mb-1">{{ $judul }}</h4>
                        <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">{{ $coverItem->deskripsi ?? 'Dokumentasi kegiatan alumni.' }}</p>
                    </div>

                    <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between gap-1">
                        <button type="button" @click="openKelolaModal(@js($judul), @js($itemsArray))" class="px-3 py-1.5 bg-sky-50 text-sky-700 hover:bg-sky-600 hover:text-white rounded-lg text-xs font-bold transition border border-sky-200 flex items-center">
                            <i class="fa-solid fa-images mr-1"></i> Kelola ({{ $totalFoto }})
                        </button>

                        <button type="button" @click="openEditModal(@js($coverItem))" class="px-3 py-1.5 bg-amber-50 text-amber-700 hover:bg-amber-600 hover:text-white rounded-lg text-xs font-bold transition border border-amber-200 flex items-center">
                            <i class="fa-solid fa-pen-to-square mr-1"></i> Edit
                        </button>

                        <form action="{{ route('admin.galeri.delete', $coverItem->id) }}" method="POST" onsubmit="return confirm('Apakah Boss yakin ingin menghapus seluruh album {{ $judul }} ini?')">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="delete_album" value="1">
                            <button type="submit" class="px-3 py-1.5 bg-red-50 text-red-600 hover:bg-red-600 hover:text-white rounded-lg text-xs font-bold transition border border-red-200 flex items-center">
                                <i class="fa-solid fa-trash mr-1"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-12 text-center bg-white rounded-2xl text-slate-400 italic border border-slate-200">
                Belum ada album galeri yang diupload.
            </div>
        @endforelse
    </div>

    <!-- Modal Tambah Galeri (Sampul Utama, Foto Dokumentasi Tambahan & Video URL) -->
    <div x-show="modalTambah" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-md p-4 overflow-y-auto" style="display: none;">
        <div @click.away="modalTambah = false" class="bg-white rounded-3xl p-6 sm:p-8 max-w-xl w-full border border-slate-200 shadow-2xl relative my-8 max-h-[90vh] overflow-y-auto">
            <button @click="modalTambah = false" class="absolute top-4 right-4 text-slate-400 hover:text-slate-900"><i class="fa-solid fa-xmark text-xl"></i></button>

            <h3 class="font-heading font-extrabold text-xl text-slate-900 mb-6 flex items-center">
                <i class="fa-solid fa-cloud-arrow-up text-amber-500 mr-2"></i>Tambah Album Foto / Video Dokumentasi
            </h3>

            <form action="{{ route('admin.galeri.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                
                <!-- Radio Switch Tipe Media -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Tipe Media *</label>
                    <div class="grid grid-cols-2 gap-3">
                        <label @click="mediaType = 'foto'" :class="mediaType === 'foto' ? 'bg-slate-900 text-white font-bold' : 'bg-slate-100 text-slate-700'" class="p-3 rounded-xl border cursor-pointer text-xs flex items-center justify-center space-x-2 transition">
                            <i class="fa-solid fa-images text-amber-400"></i>
                            <span>Album Foto Dokumentasi</span>
                        </label>
                        <label @click="mediaType = 'video'" :class="mediaType === 'video' ? 'bg-slate-900 text-white font-bold' : 'bg-slate-100 text-slate-700'" class="p-3 rounded-xl border cursor-pointer text-xs flex items-center justify-center space-x-2 transition">
                            <i class="fa-solid fa-film text-rose-400"></i>
                            <span>Video Dokumentasi</span>
                        </label>
                    </div>
                    <input type="hidden" name="tipe" :value="mediaType">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Kegiatan / Judul Album *</label>
                    <input type="text" name="judul" required placeholder="Contoh: Reuni Akbar Angkatan 2015 / Bakti Sosial 2026" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-900">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Kategori Kegiatan *</label>
                        <select name="kategori" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-900">
                            <option value="Reuni">Reuni</option>
                            <option value="Beasiswa">Beasiswa</option>
                            <option value="Bakti Sosial">Bakti Sosial</option>
                            <option value="Rapat">Rapat Kerja</option>
                            <option value="Olahraga & Seni">Olahraga & Seni</option>
                        </select>
                    </div>

                    <!-- Input Video URL jika tipe Video -->
                    <div x-show="mediaType === 'video'">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Link Video YouTube (URL / Embed) *</label>
                        <input type="text" name="video_url" placeholder="https://www.youtube.com/watch?v=..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-900">
                    </div>
                </div>

                <!-- Input Foto Sampul Utama -->
                <div class="p-4 bg-amber-50 rounded-2xl border border-amber-200">
                    <label class="block text-xs font-bold text-amber-900 uppercase tracking-wider mb-1">
                        <i class="fa-solid fa-star text-amber-500 mr-1"></i>Foto Sampul Utama / Cover Album <span x-show="mediaType === 'foto'">*</span>
                    </label>
                    <input type="file" name="gambar_sampul" accept="image/*" :required="mediaType === 'foto'" class="w-full px-3 py-2 bg-white border border-amber-300 rounded-xl text-xs text-slate-900 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-slate-900 file:text-white">
                    <span class="text-[10px] text-amber-700 mt-1 block">*Foto utama yang tampil sebagai halaman depan kartu album (Auto Convert WebP).</span>
                </div>

                <!-- Input Foto Dokumentasi Lainnya (Multiple) -->
                <div x-show="mediaType === 'foto'" class="p-4 bg-slate-50 rounded-2xl border border-slate-200">
                    <label class="block text-xs font-bold text-slate-800 uppercase tracking-wider mb-1">
                        <i class="fa-solid fa-images text-sky-500 mr-1"></i>Foto Dokumentasi Tambahan (Bisa Pilih Banyak Foto)
                    </label>
                    <input type="file" name="gambar_lainnya[]" multiple accept="image/*" class="w-full px-3 py-2 bg-white border border-slate-300 rounded-xl text-xs text-slate-900 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-slate-900 file:text-white">
                    <span class="text-[10px] text-slate-500 mt-1 block">*Pilih foto-foto pendukung kegiatan sekaligus (Ctrl/Shift + klik dari HP/Laptop).</span>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Deskripsi / Keterangan Momen</label>
                    <textarea name="deskripsi" rows="2" placeholder="Keterangan singkat momen kegiatan..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-900"></textarea>
                </div>

                <div class="pt-4 flex justify-end space-x-3 border-t border-slate-100">
                    <button type="button" @click="modalTambah = false" class="px-5 py-2.5 bg-slate-100 text-slate-700 text-sm font-semibold rounded-xl border border-slate-300">Batal</button>
                    <button type="submit" class="px-6 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-sm rounded-xl shadow-md">
                        <i class="fa-solid fa-cloud-arrow-up mr-1.5 text-amber-400"></i>Simpan Album / Media
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Item Galeri -->
    <div x-show="modalEdit" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-md p-4" style="display: none;">
        <div @click.away="modalEdit = false" class="bg-white rounded-3xl p-6 sm:p-8 max-w-lg w-full border border-slate-200 shadow-2xl relative">
            <button @click="modalEdit = false" class="absolute top-4 right-4 text-slate-400 hover:text-slate-900"><i class="fa-solid fa-xmark text-xl"></i></button>

            <h3 class="font-heading font-extrabold text-xl text-slate-900 mb-6 flex items-center">
                <i class="fa-solid fa-pen-to-square text-amber-500 mr-2"></i>Edit Item Galeri / Video
            </h3>

            <form :action="'{{ url('/admin/galeri') }}/' + editData.id" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')
                <input type="hidden" name="tipe" :value="editData.tipe || 'foto'">

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Judul / Nama Kegiatan *</label>
                    <input type="text" name="judul" x-model="editData.judul" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-900">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Kategori *</label>
                        <select name="kategori" x-model="editData.kategori" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-900">
                            <option value="Reuni">Reuni</option>
                            <option value="Beasiswa">Beasiswa</option>
                            <option value="Bakti Sosial">Bakti Sosial</option>
                            <option value="Rapat">Rapat Kerja</option>
                            <option value="Olahraga & Seni">Olahraga & Seni</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Ganti Foto (Opsional)</label>
                        <input type="file" name="gambar" accept="image/*" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-900 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-slate-900 file:text-white">
                    </div>
                </div>

                <div x-show="editData.tipe === 'video'">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Link Video YouTube (URL / Embed)</label>
                    <input type="text" name="video_url" x-model="editData.video_url" placeholder="https://www.youtube.com/watch?v=..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-900">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Deskripsi Keterangan</label>
                    <textarea name="deskripsi" x-model="editData.deskripsi" rows="2" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-900"></textarea>
                </div>

                <div class="pt-4 flex justify-end space-x-3">
                    <button type="button" @click="modalEdit = false" class="px-5 py-2.5 bg-slate-100 text-slate-700 text-sm font-semibold rounded-xl border border-slate-300">Batal</button>
                    <button type="submit" class="px-6 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-sm rounded-xl shadow-md">
                        <i class="fa-solid fa-save mr-1.5 text-amber-400"></i>Perbarui Galeri
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Kelola Foto Dalam Album -->
    <div x-show="modalKelolaFoto" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-md p-4 overflow-y-auto" style="display: none;">
        <div @click.away="modalKelolaFoto = false" class="bg-white rounded-3xl p-6 sm:p-8 max-w-3xl w-full border border-slate-200 shadow-2xl relative my-8 max-h-[85vh] flex flex-col">
            <button @click="modalKelolaFoto = false" class="absolute top-4 right-4 text-slate-400 hover:text-slate-900"><i class="fa-solid fa-xmark text-xl"></i></button>

            <div class="mb-4 shrink-0 border-b border-slate-200 pb-3">
                <span class="text-xs uppercase font-bold text-amber-600 tracking-wider">Kelola Isi Album Foto</span>
                <h3 class="font-heading font-extrabold text-xl text-slate-900" x-text="selectedAlbumTitle"></h3>
            </div>

            <!-- Scrollable Photos Grid inside Modal -->
            <div class="overflow-y-auto flex-grow pr-1 space-y-4">
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                    <template x-for="item in selectedAlbumItems" :key="item.id">
                        <div class="bg-slate-50 rounded-xl overflow-hidden border border-slate-200 relative group flex flex-col justify-between">
                            <div class="h-32 relative bg-slate-900 overflow-hidden">
                                <img :src="item.gambar.startsWith('http') ? item.gambar : '{{ url('/') }}/' + item.gambar" class="w-full h-full object-cover">
                                <template x-if="item.is_cover">
                                    <span class="absolute top-1 left-1 px-2 py-0.5 bg-amber-500 text-slate-950 font-black text-[9px] uppercase rounded-md shadow-sm">
                                        Sampul
                                    </span>
                                </template>
                            </div>
                            <div class="p-2 flex items-center justify-between bg-white border-t border-slate-100">
                                <span class="text-[10px] text-slate-500 font-medium truncate" x-text="item.is_cover ? 'Sampul Utama' : 'Foto Dokumentasi'"></span>
                                <form :action="'{{ url('/admin/galeri') }}/' + item.id" method="POST" onsubmit="return confirm('Hapus foto ini dari album?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-2 py-1 bg-red-50 text-red-600 hover:bg-red-600 hover:text-white rounded text-[10px] font-bold transition border border-red-200">
                                        <i class="fa-solid fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-200 flex justify-end shrink-0">
                <button @click="modalKelolaFoto = false" class="px-6 py-2.5 bg-slate-900 text-white font-bold text-xs rounded-xl">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection
