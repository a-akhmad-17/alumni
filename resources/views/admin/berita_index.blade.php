@extends('layouts.admin_layout')

@section('title', 'Manajemen Berita & Kegiatan - Dasbor Internal')

@push('styles')
<style>
    /* Styling khusus agar CKEditor 5 terlihat rapi & modern */
    .ck-editor__editable_inline {
        min-height: 220px;
        background-color: #f8fafc !important;
        border-bottom-left-radius: 0.75rem !important;
        border-bottom-right-radius: 0.75rem !important;
    }
    .ck-toolbar {
        border-top-left-radius: 0.75rem !important;
        border-top-right-radius: 0.75rem !important;
        background-color: #f1f5f9 !important;
        border-color: #cbd5e1 !important;
    }
</style>
@endpush

@section('content')
<div id="berita-manager" class="space-y-6" x-data="{ modalTambah: false, modalEdit: false, editData: {} }">
    <!-- Header Card -->
    <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <span class="text-xs uppercase font-bold text-amber-600 tracking-wider block mb-1">Manajemen Halaman Publik</span>
            <h1 class="font-heading font-extrabold text-2xl text-slate-900">Berita & Kegiatan Alumni</h1>
            <p class="text-xs text-slate-500 mt-1">Upload gambar dari laptop/HP (otomatis dikonversi ke format WebP) dan kelola artikel berita.</p>
        </div>

        <button @click="modalTambah = true" class="px-6 py-3 bg-slate-900 hover:bg-slate-800 text-white font-bold text-sm rounded-xl shadow-md transition flex items-center justify-center shrink-0">
            <i class="fa-solid fa-plus mr-2 text-amber-400"></i>Terbitkan Berita Baru
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
        <form method="GET" action="{{ route('admin.berita') }}" class="mb-6 grid grid-cols-1 sm:grid-cols-12 gap-3">
            <div class="sm:col-span-6 relative">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul berita..." class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-900 focus:outline-none focus:border-slate-800">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3 text-slate-400 text-xs"></i>
            </div>
            <div class="sm:col-span-3">
                <select name="kategori" onchange="this.form.submit()" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs font-semibold text-slate-700 focus:outline-none focus:border-slate-800">
                    <option value="semua" {{ request('kategori') == 'semua' ? 'selected' : '' }}>Semua Kategori</option>
                    @if(isset($kategoriMasterList))
                        @foreach($kategoriMasterList as $kMaster)
                            <option value="{{ $kMaster->nama_kategori }}" {{ request('kategori') == $kMaster->nama_kategori ? 'selected' : '' }}>{{ $kMaster->nama_kategori }}</option>
                        @endforeach
                    @else
                        <option value="Berita" {{ request('kategori') == 'Berita' ? 'selected' : '' }}>Berita</option>
                        <option value="Kegiatan" {{ request('kategori') == 'Kegiatan' ? 'selected' : '' }}>Kegiatan</option>
                        <option value="Pengumuman" {{ request('kategori') == 'Pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                        <option value="Opini" {{ request('kategori') == 'Opini' ? 'selected' : '' }}>Opini</option>
                    @endif
                </select>
            </div>
            <div class="sm:col-span-3 flex gap-2">
                <select name="status" onchange="this.form.submit()" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs font-semibold text-slate-700 focus:outline-none focus:border-slate-800">
                    <option value="semua" {{ request('status') == 'semua' ? 'selected' : '' }}>Semua Status</option>
                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                </select>
                @if(request()->hasAny(['q', 'kategori', 'status']))
                    <a href="{{ route('admin.berita') }}" class="px-3 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-bold transition flex items-center justify-center shrink-0" title="Reset Filter">
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>
                @endif
            </div>
        </form>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-700">
                <thead class="bg-slate-50 text-xs uppercase font-bold text-slate-500 border-b border-slate-200">
                    <tr>
                        <th class="p-3">Gambar</th>
                        <th class="p-3">Judul Berita</th>
                        <th class="p-3">Kategori</th>
                        <th class="p-3">Penulis</th>
                        <th class="p-3">Tanggal Terbit</th>
                        <th class="p-3">Status</th>
                        <th class="p-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($beritaList as $brt)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="p-3">
                                <img src="{{ asset($brt->gambar) }}" alt="{{ $brt->judul }}" class="w-12 h-12 rounded-xl object-cover shadow-sm bg-slate-900">
                            </td>
                            <td class="p-3 font-semibold text-slate-900 max-w-xs">
                                <a href="{{ route('berita.detail', $brt->slug) }}" target="_blank" class="hover:text-amber-600 transition line-clamp-2">{{ $brt->judul }}</a>
                            </td>
                            <td class="p-3">
                                @php
                                    $catColors = [
                                        'Berita' => 'bg-sky-50 text-sky-700 border-sky-200',
                                        'Kegiatan' => 'bg-amber-50 text-amber-700 border-amber-200',
                                        'Pengumuman' => 'bg-purple-50 text-purple-700 border-purple-200',
                                        'Opini' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                    ];
                                    $catClass = $catColors[$brt->kategori ?? 'Berita'] ?? 'bg-slate-50 text-slate-700 border-slate-200';
                                @endphp
                                <span class="px-2.5 py-0.5 rounded-full border text-[10px] font-bold uppercase {{ $catClass }}">
                                    {{ $brt->kategori ?? 'Berita' }}
                                </span>
                            </td>
                            <td class="p-3 text-xs">{{ $brt->penulis }}</td>
                            <td class="p-3 text-xs text-slate-500">{{ \Carbon\Carbon::parse($brt->created_at)->format('d M Y') }}</td>
                            <td class="p-3">
                                @if(($brt->status ?? 'published') === 'published')
                                    <span class="px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 text-[10px] font-bold uppercase flex items-center w-fit">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5 animate-pulse"></span>Published
                                    </span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-600 border border-slate-300 text-[10px] font-bold uppercase flex items-center w-fit">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400 mr-1.5"></span>Draft
                                    </span>
                                @endif
                            </td>
                            <td class="p-3 flex items-center justify-center space-x-2">
                                <button @click="openEditModal(@js($brt))" class="px-3 py-1.5 bg-amber-50 text-amber-700 hover:bg-amber-600 hover:text-white rounded-lg text-xs font-bold transition border border-amber-200 flex items-center">
                                    <i class="fa-solid fa-pen-to-square mr-1"></i> Edit
                                </button>
                                <form action="{{ route('admin.berita.delete', $brt->id) }}" method="POST" onsubmit="return confirm('Apakah Boss yakin ingin menghapus berita ini?')">
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
                            <td colspan="7" class="p-8 text-center text-slate-400 italic">Belum ada berita yang diterbitkan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="pt-4">
            {{ $beritaList->links() }}
        </div>
    </div>

    <!-- Modal Tambah Berita (Dengan CKEditor 5 Modern & Upload File) -->
    <div x-show="modalTambah" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-md p-4 overflow-y-auto" style="display: none;">
        <div @click.away="modalTambah = false" class="bg-white rounded-3xl p-6 sm:p-8 max-w-3xl w-full border border-slate-200 shadow-2xl relative my-8 max-h-[90vh] overflow-y-auto">
            <button @click="modalTambah = false" class="absolute top-4 right-4 text-slate-400 hover:text-slate-900"><i class="fa-solid fa-xmark text-xl"></i></button>

            <h3 class="font-heading font-extrabold text-xl text-slate-900 mb-6 flex items-center">
                <i class="fa-solid fa-newspaper text-amber-500 mr-2"></i>Terbitkan Berita / Kegiatan Baru
            </h3>

            <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data" id="formTambahBerita" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Judul Berita *</label>
                    <input type="text" name="judul" required placeholder="Judul artikel berita..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-900">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Upload Gambar Header *</label>
                        <input type="file" name="gambar" accept="image/*" required class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-900 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-slate-900 file:text-white">
                        <span class="text-[10px] text-slate-400 mt-1 block">*Otomatis dikonversi ke format WebP terkompresi.</span>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Kategori Berita *</label>
                        <select name="kategori" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-900">
                            @if(isset($kategoriMasterList))
                                @foreach($kategoriMasterList as $kMaster)
                                    <option value="{{ $kMaster->nama_kategori }}">{{ $kMaster->nama_kategori }}</option>
                                @endforeach
                            @else
                                <option value="Berita">Berita</option>
                                <option value="Kegiatan">Kegiatan</option>
                                <option value="Pengumuman">Pengumuman</option>
                                <option value="Opini">Opini</option>
                            @endif
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Status Publikasi *</label>
                        <select name="status" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-900">
                            <option value="published">Published (Terbit)</option>
                            <option value="draft">Draft (Simpan Draf)</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Ringkasan Berita *</label>
                    <textarea name="ringkasan" required rows="2" placeholder="Ringkasan singkat artikel..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-900"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Isi Lengkap Berita (CKEditor 5 Text Editor) *</label>
                    <textarea id="ckeditor" placeholder="Tulis artikel di sini..."></textarea>
                    <input type="hidden" name="isi" id="isiInput" required>
                </div>

                <div class="pt-4 flex justify-end space-x-3 border-t border-slate-100">
                    <button type="button" @click="modalTambah = false" class="px-5 py-2.5 bg-slate-100 text-slate-700 text-sm font-semibold rounded-xl border border-slate-300">Batal</button>
                    <button type="submit" class="px-6 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-sm rounded-xl shadow-md">
                        <i class="fa-solid fa-paper-plane mr-1.5 text-amber-400"></i>Terbitkan Berita
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Berita -->
    <div x-show="modalEdit" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-md p-4 overflow-y-auto" style="display: none;">
        <div @click.away="modalEdit = false" class="bg-white rounded-3xl p-6 sm:p-8 max-w-3xl w-full border border-slate-200 shadow-2xl relative my-8 max-h-[90vh] overflow-y-auto">
            <button @click="modalEdit = false" class="absolute top-4 right-4 text-slate-400 hover:text-slate-900"><i class="fa-solid fa-xmark text-xl"></i></button>

            <h3 class="font-heading font-extrabold text-xl text-slate-900 mb-6 flex items-center">
                <i class="fa-solid fa-pen-to-square text-amber-500 mr-2"></i>Edit Berita / Kegiatan
            </h3>

            <form :action="'{{ url('/admin/berita') }}/' + editData.id" method="POST" enctype="multipart/form-data" id="formEditBerita" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Judul Berita *</label>
                    <input type="text" name="judul" x-model="editData.judul" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-900">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Ganti Gambar Header (Opsional)</label>
                        <input type="file" name="gambar" accept="image/*" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-900 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-slate-900 file:text-white">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Kategori Berita *</label>
                        <select name="kategori" x-model="editData.kategori" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-900">
                            @if(isset($kategoriMasterList))
                                @foreach($kategoriMasterList as $kMaster)
                                    <option value="{{ $kMaster->nama_kategori }}">{{ $kMaster->nama_kategori }}</option>
                                @endforeach
                            @else
                                <option value="Berita">Berita</option>
                                <option value="Kegiatan">Kegiatan</option>
                                <option value="Pengumuman">Pengumuman</option>
                                <option value="Opini">Opini</option>
                            @endif
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Status Publikasi *</label>
                        <select name="status" x-model="editData.status" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-900">
                            <option value="published">Published (Terbit)</option>
                            <option value="draft">Draft (Simpan Draf)</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Ringkasan Berita *</label>
                    <textarea name="ringkasan" x-model="editData.ringkasan" required rows="2" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-900"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Isi Lengkap Berita (CKEditor 5 Text Editor) *</label>
                    <textarea id="ckeditorEdit" placeholder="Tulis artikel di sini..."></textarea>
                    <input type="hidden" name="isi" id="isiInputEdit" required>
                </div>

                <div class="pt-4 flex justify-end space-x-3 border-t border-slate-100">
                    <button type="button" @click="modalEdit = false" class="px-5 py-2.5 bg-slate-100 text-slate-700 text-sm font-semibold rounded-xl border border-slate-300">Batal</button>
                    <button type="submit" class="px-6 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-sm rounded-xl shadow-md">
                        <i class="fa-solid fa-save mr-1.5 text-amber-400"></i>Perbarui Berita
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- CKEditor 5 Modern CDN -->
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    let editorInstance;
    let editorEditInstance;

    document.addEventListener('DOMContentLoaded', function () {
        ClassicEditor
            .create(document.querySelector('#ckeditor'), {
                toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'undo', 'redo'],
                placeholder: 'Ketikkan isi artikel berita lengkap di sini...'
            })
            .then(editor => {
                editorInstance = editor;
            })
            .catch(error => console.error(error));

        ClassicEditor
            .create(document.querySelector('#ckeditorEdit'), {
                toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'undo', 'redo'],
                placeholder: 'Ketikkan isi artikel berita lengkap di sini...'
            })
            .then(editor => {
                editorEditInstance = editor;
            })
            .catch(error => console.error(error));

        var formTambah = document.getElementById('formTambahBerita');
        if (formTambah) {
            formTambah.onsubmit = function () {
                if (editorInstance) {
                    document.getElementById('isiInput').value = editorInstance.getData();
                }
            };
        }

        var formEdit = document.getElementById('formEditBerita');
        if (formEdit) {
            formEdit.onsubmit = function () {
                if (editorEditInstance) {
                    document.getElementById('isiInputEdit').value = editorEditInstance.getData();
                }
            };
        }
    });

    function openEditModal(beritaData) {
        let el = document.getElementById('berita-manager');
        if (el) {
            let data = (window.Alpine && Alpine.$data) ? Alpine.$data(el) : (el._x_dataStack ? el._x_dataStack[0] : null);
            if (data) {
                if (!beritaData.kategori) beritaData.kategori = 'Berita';
                if (!beritaData.status) beritaData.status = 'published';
                data.editData = beritaData;
                data.modalEdit = true;
                if (editorEditInstance) {
                    editorEditInstance.setData(beritaData.isi || '');
                }
                var inputEdit = document.getElementById('isiInputEdit');
                if (inputEdit) {
                    inputEdit.value = beritaData.isi || '';
                }
            }
        }
    }
</script>
@endpush
