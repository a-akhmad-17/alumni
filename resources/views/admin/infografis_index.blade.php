@extends('layouts.admin_layout')

@section('title', 'Kelola Infografis & Popup Flyer')

@section('content')
<div x-data="{ modalAdd: {{ $errors->any() ? 'true' : 'false' }}, modalEdit: false, selectedInfografis: {} }">
    
    <!-- Top Header -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="font-heading text-2xl font-extrabold text-slate-900">Kelola Infografis & Announcement Flyer</h1>
            <p class="text-xs text-slate-500 mt-1">Upload flyer pengumuman dan aktifkan opsi **Popup Flyer Beranda** (Maksimal 3 flyer aktif di popup).</p>
        </div>

        <div class="flex items-center space-x-3">
            <span class="px-3 py-1.5 rounded-xl bg-amber-50 text-amber-900 border border-amber-300 text-xs font-bold">
                <i class="fa-solid fa-bullhorn mr-1.5 text-amber-600"></i>{{ $popupCount }} / 3 Flyer Popup Aktif
            </span>
            <button @click="modalAdd = true" class="px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-xl shadow-md transition flex items-center shrink-0">
                <i class="fa-solid fa-plus mr-2 text-amber-400"></i>Tambah Flyer Baru
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold flex items-center justify-between shadow-sm">
            <div class="flex items-center space-x-2">
                <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-bold flex items-center justify-between shadow-sm">
            <div class="flex items-center space-x-2">
                <i class="fa-solid fa-circle-xmark text-rose-600 text-base"></i>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-bold shadow-sm space-y-1">
            <div class="flex items-center space-x-2">
                <i class="fa-solid fa-triangle-exclamation text-rose-600 text-base"></i>
                <span>Gagal menyimpan data infografis:</span>
            </div>
            <ul class="list-disc list-inside pl-5 font-normal">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Search & Filter Bar -->
    <div class="bg-white rounded-2xl p-4 mb-6 border border-slate-200 shadow-sm">
        <form action="{{ route('admin.infografis') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <div class="sm:col-span-8">
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <i class="fa-solid fa-search text-xs"></i>
                    </span>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul flyer / infografis..." class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-900 focus:outline-none focus:border-slate-900">
                </div>
            </div>

            <div class="sm:col-span-4 flex items-center space-x-2">
                <select name="status" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-900 focus:outline-none focus:border-slate-900">
                    <option value="semua">Semua Status</option>
                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                </select>
                <button type="submit" class="px-4 py-2 bg-slate-900 text-white font-bold text-xs rounded-xl shadow">Filter</button>
            </div>
        </form>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-6">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-700 uppercase text-[11px] font-bold border-b border-slate-200">
                        <th class="py-3 px-4">Flyer Preview</th>
                        <th class="py-3 px-4">Judul Infografis</th>
                        <th class="py-3 px-4 text-center">Popup Beranda</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs">
                    @forelse($infografisList as $item)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-3 px-4">
                                <img src="{{ str_starts_with($item->gambar, 'http') ? $item->gambar : asset($item->gambar) }}" alt="Flyer" class="w-16 h-20 object-cover rounded-lg border border-slate-200">
                            </td>
                            <td class="py-3 px-4 max-w-xs">
                                <h4 class="font-bold text-slate-900 text-sm line-clamp-1">{{ $item->judul }}</h4>
                                <p class="text-slate-500 text-[11px] line-clamp-2 mt-0.5">{{ $item->deskripsi ?? '-' }}</p>
                                @if($item->link_tautan)
                                    <a href="{{ $item->link_tautan }}" target="_blank" class="text-sky-600 font-semibold text-[10px] hover:underline block truncate mt-1">
                                        <i class="fa-solid fa-link mr-1"></i>{{ $item->link_tautan }}
                                    </a>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-center">
                                <form action="{{ route('admin.infografis.togglePopup', $item->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="px-3 py-1.5 rounded-full text-[10px] font-extrabold uppercase tracking-wider transition flex items-center justify-center mx-auto border {{ $item->is_popup ? 'bg-amber-500 text-slate-950 border-amber-600 shadow-sm' : 'bg-slate-100 text-slate-500 border-slate-300 hover:bg-slate-200' }}">
                                        <i class="fa-solid {{ $item->is_popup ? 'fa-circle-check text-slate-950' : 'fa-circle text-slate-400' }} mr-1.5"></i>
                                        <span>{{ $item->is_popup ? 'Aktif Popup' : 'Non-Aktif' }}</span>
                                    </button>
                                </form>
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $item->status == 'published' ? 'bg-emerald-100 text-emerald-800 border border-emerald-300' : 'bg-slate-100 text-slate-700 border border-slate-300' }}">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <button @click="modalEdit = true; selectedInfografis = @js($item)" class="p-2 rounded-lg bg-amber-50 text-amber-700 hover:bg-amber-100 border border-amber-200 transition" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <form action="{{ route('admin.infografis.delete', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus flyer infografis ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg bg-rose-50 text-rose-700 hover:bg-rose-100 border border-rose-200 transition" title="Hapus">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-slate-500">Belum ada data infografis.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div>
        {{ $infografisList->links() }}
    </div>

    <!-- MODAL TAMBAH INFOGRAFIS -->
    <div x-show="modalAdd" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/70 backdrop-blur-md p-4 overflow-y-auto" style="display: none;">
        <div @click.away="modalAdd = false" class="bg-white rounded-3xl p-6 max-w-lg w-full border border-slate-200 shadow-2xl relative my-8">
            <button @click="modalAdd = false" class="absolute top-4 right-4 w-8 h-8 rounded-full bg-slate-100 text-slate-500 hover:text-slate-900 flex items-center justify-center">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <h3 class="font-heading font-extrabold text-lg text-slate-900 mb-4">Tambah Flyer / Infografis Baru</h3>

            <form action="{{ route('admin.infografis.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Judul Infografis / Flyer *</label>
                    <input type="text" name="judul" required placeholder="Contoh: Pengumuman Mubes IKA SMAN Kajuara 2026" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-900 focus:outline-none focus:border-slate-900">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Deskripsi Singkat (Opsional)</label>
                    <textarea name="deskripsi" rows="3" placeholder="Informasi singkat penjelasan flyer..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-900 focus:outline-none focus:border-slate-900"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Link Tautan Terkait (Opsional)</label>
                    <input type="url" name="link_tautan" placeholder="https://..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-900 focus:outline-none focus:border-slate-900">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Upload Gambar Flyer (Auto WebP) *</label>
                    <input type="file" name="gambar" required accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-slate-900 file:text-white">
                </div>

                <div class="flex items-center justify-between p-3 rounded-2xl bg-amber-50 border border-amber-200">
                    <div>
                        <span class="block text-xs font-bold text-slate-900">Tampilkan di Popup Beranda</span>
                        <span class="text-[10px] text-slate-500">Otomatis muncul saat homepage pertama dibuka (Max 3 flyer)</span>
                    </div>
                    <input type="checkbox" name="is_popup" value="1" class="w-5 h-5 rounded border-slate-300 text-slate-900 focus:ring-slate-900">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Status Publikasi</label>
                    <select name="status" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-900 focus:outline-none focus:border-slate-900">
                        <option value="published">Published</option>
                        <option value="draft">Draft</option>
                    </select>
                </div>

                <div class="pt-4 flex justify-end space-x-3 border-t border-slate-100">
                    <button type="button" @click="modalAdd = false" class="px-5 py-2 text-xs font-bold text-slate-700 bg-slate-100 rounded-xl">Batal</button>
                    <button type="submit" class="px-5 py-2 text-xs font-bold text-white bg-slate-900 hover:bg-slate-800 rounded-xl shadow">Simpan Infografis</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EDIT INFOGRAFIS -->
    <div x-show="modalEdit" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/70 backdrop-blur-md p-4 overflow-y-auto" style="display: none;">
        <div @click.away="modalEdit = false" class="bg-white rounded-3xl p-6 max-w-lg w-full border border-slate-200 shadow-2xl relative my-8">
            <button @click="modalEdit = false" class="absolute top-4 right-4 w-8 h-8 rounded-full bg-slate-100 text-slate-500 hover:text-slate-900 flex items-center justify-center">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <h3 class="font-heading font-extrabold text-lg text-slate-900 mb-4">Edit Data Infografis</h3>

            <form :action="'{{ url('/admin/infografis') }}/' + selectedInfografis.id" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Judul Infografis / Flyer *</label>
                    <input type="text" name="judul" x-model="selectedInfografis.judul" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-900 focus:outline-none focus:border-slate-900">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Deskripsi Singkat (Opsional)</label>
                    <textarea name="deskripsi" x-model="selectedInfografis.deskripsi" rows="3" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-900 focus:outline-none focus:border-slate-900"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Link Tautan Terkait (Opsional)</label>
                    <input type="url" name="link_tautan" x-model="selectedInfografis.link_tautan" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-900 focus:outline-none focus:border-slate-900">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Ganti Gambar Flyer (Opsional)</label>
                    <input type="file" name="gambar" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-slate-900 file:text-white">
                </div>

                <div class="flex items-center justify-between p-3 rounded-2xl bg-amber-50 border border-amber-200">
                    <div>
                        <span class="block text-xs font-bold text-slate-900">Tampilkan di Popup Beranda</span>
                        <span class="text-[10px] text-slate-500">Otomatis muncul saat homepage pertama dibuka</span>
                    </div>
                    <input type="checkbox" name="is_popup" value="1" :checked="selectedInfografis.is_popup == 1" class="w-5 h-5 rounded border-slate-300 text-slate-900 focus:ring-slate-900">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Status Publikasi</label>
                    <select name="status" x-model="selectedInfografis.status" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-900 focus:outline-none focus:border-slate-900">
                        <option value="published">Published</option>
                        <option value="draft">Draft</option>
                    </select>
                </div>

                <div class="pt-4 flex justify-end space-x-3 border-t border-slate-100">
                    <button type="button" @click="modalEdit = false" class="px-5 py-2 text-xs font-bold text-slate-700 bg-slate-100 rounded-xl">Batal</button>
                    <button type="submit" class="px-5 py-2 text-xs font-bold text-white bg-slate-900 hover:bg-slate-800 rounded-xl shadow">Update Infografis</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
