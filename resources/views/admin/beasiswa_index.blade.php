@extends('layouts.admin_layout')

@section('title', 'Kelola Informasi Beasiswa')

@section('content')
<div x-data="{ modalAdd: false, modalEdit: false, selectedBeasiswa: {} }">
    
    <!-- Top Header -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="font-heading text-2xl font-extrabold text-slate-900">Kelola Informasi Beasiswa</h1>
            <p class="text-xs text-slate-500 mt-1">Kelola data banner beasiswa, informasi ringkas, dan link pendaftaran eksternal.</p>
        </div>

        <button @click="modalAdd = true" class="px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-xl shadow-md transition flex items-center shrink-0">
            <i class="fa-solid fa-plus mr-2 text-amber-400"></i>Tambah Beasiswa Baru
        </button>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold flex items-center justify-between shadow-sm">
            <div class="flex items-center space-x-2">
                <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <!-- Search & Filter Bar -->
    <div class="bg-white rounded-2xl p-4 mb-6 border border-slate-200 shadow-sm">
        <form action="{{ route('admin.beasiswa') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <div class="sm:col-span-8">
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <i class="fa-solid fa-search text-xs"></i>
                    </span>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul beasiswa..." class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-900 focus:outline-none focus:border-slate-900">
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
                        <th class="py-3 px-4">Banner Image</th>
                        <th class="py-3 px-4">Judul Beasiswa</th>
                        <th class="py-3 px-4">Link Eksternal</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs">
                    @forelse($beasiswaList as $beasiswa)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-3 px-4">
                                @if($beasiswa->gambar)
                                    <img src="{{ asset($beasiswa->gambar) }}" alt="Banner" class="w-24 h-14 object-cover rounded-lg border border-slate-200">
                                @else
                                    <div class="w-24 h-14 bg-slate-100 rounded-lg border border-slate-200 flex items-center justify-center text-slate-400">No Image</div>
                                @endif
                            </td>
                            <td class="py-3 px-4 max-w-xs">
                                <h4 class="font-bold text-slate-900 text-sm line-clamp-1">{{ $beasiswa->judul }}</h4>
                                <p class="text-slate-500 text-[11px] line-clamp-2 mt-0.5">{{ Str::limit(strip_tags($beasiswa->informasi), 80) }}</p>
                            </td>
                            <td class="py-3 px-4">
                                <a href="{{ $beasiswa->link_eksternal }}" target="_blank" class="text-sky-600 font-semibold hover:underline flex items-center max-w-[200px] truncate">
                                    <i class="fa-solid fa-arrow-up-right-from-square mr-1 text-[10px]"></i>
                                    <span class="truncate">{{ $beasiswa->link_eksternal }}</span>
                                </a>
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $beasiswa->status == 'published' ? 'bg-emerald-100 text-emerald-800 border border-emerald-300' : 'bg-slate-100 text-slate-700 border border-slate-300' }}">
                                    {{ $beasiswa->status }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <button @click="modalEdit = true; selectedBeasiswa = @js($beasiswa)" class="p-2 rounded-lg bg-amber-50 text-amber-700 hover:bg-amber-100 border border-amber-200 transition" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <form action="{{ route('admin.beasiswa.delete', $beasiswa->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus informasi beasiswa ini?')">
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
                            <td colspan="5" class="py-8 text-center text-slate-500">Belum ada data beasiswa.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div>
        {{ $beasiswaList->links() }}
    </div>

    <!-- MODAL TAMBAH BEASISWA -->
    <div x-show="modalAdd" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/70 backdrop-blur-md p-4 overflow-y-auto" style="display: none;">
        <div @click.away="modalAdd = false" class="bg-white rounded-3xl p-6 max-w-lg w-full border border-slate-200 shadow-2xl relative my-8">
            <button @click="modalAdd = false" class="absolute top-4 right-4 w-8 h-8 rounded-full bg-slate-100 text-slate-500 hover:text-slate-900 flex items-center justify-center">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <h3 class="font-heading font-extrabold text-lg text-slate-900 mb-4">Tambah Beasiswa Baru</h3>

            <form action="{{ route('admin.beasiswa.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nama / Judul Beasiswa *</label>
                    <input type="text" name="judul" required placeholder="Contoh: Beasiswa Prestasi Alumni SMAN Kajuara 2026" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-900 focus:outline-none focus:border-slate-900">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Informasi / Deskripsi Beasiswa *</label>
                    <textarea name="informasi" required rows="4" placeholder="Tuliskan detail singkat mengenai beasiswa, syarat, dan benefit..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-900 focus:outline-none focus:border-slate-900"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Link Eksternal Pendaftaran / Web Resmi *</label>
                    <input type="url" name="link_eksternal" required placeholder="https://beasiswa.example.com atau link Form" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-900 focus:outline-none focus:border-slate-900">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Banner Gambar (WebP)</label>
                        <input type="file" name="gambar" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-slate-900 file:text-white">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Status Publikasi</label>
                        <select name="status" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-900 focus:outline-none focus:border-slate-900">
                            <option value="published">Published</option>
                            <option value="draft">Draft</option>
                        </select>
                    </div>
                </div>

                <div class="pt-4 flex justify-end space-x-3 border-t border-slate-100">
                    <button type="button" @click="modalAdd = false" class="px-5 py-2 text-xs font-bold text-slate-700 bg-slate-100 rounded-xl">Batal</button>
                    <button type="submit" class="px-5 py-2 text-xs font-bold text-white bg-slate-900 hover:bg-slate-800 rounded-xl shadow">Simpan Beasiswa</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EDIT BEASISWA -->
    <div x-show="modalEdit" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/70 backdrop-blur-md p-4 overflow-y-auto" style="display: none;">
        <div @click.away="modalEdit = false" class="bg-white rounded-3xl p-6 max-w-lg w-full border border-slate-200 shadow-2xl relative my-8">
            <button @click="modalEdit = false" class="absolute top-4 right-4 w-8 h-8 rounded-full bg-slate-100 text-slate-500 hover:text-slate-900 flex items-center justify-center">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <h3 class="font-heading font-extrabold text-lg text-slate-900 mb-4">Edit Informasi Beasiswa</h3>

            <form :action="'{{ url('/admin/beasiswa') }}/' + selectedBeasiswa.id" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nama / Judul Beasiswa *</label>
                    <input type="text" name="judul" x-model="selectedBeasiswa.judul" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-900 focus:outline-none focus:border-slate-900">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Informasi / Deskripsi Beasiswa *</label>
                    <textarea name="informasi" x-model="selectedBeasiswa.informasi" required rows="4" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-900 focus:outline-none focus:border-slate-900"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Link Eksternal Pendaftaran / Web Resmi *</label>
                    <input type="url" name="link_eksternal" x-model="selectedBeasiswa.link_eksternal" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-900 focus:outline-none focus:border-slate-900">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Ganti Banner (Opsional)</label>
                        <input type="file" name="gambar" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-slate-900 file:text-white">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Status Publikasi</label>
                        <select name="status" x-model="selectedBeasiswa.status" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-900 focus:outline-none focus:border-slate-900">
                            <option value="published">Published</option>
                            <option value="draft">Draft</option>
                        </select>
                    </div>
                </div>

                <div class="pt-4 flex justify-end space-x-3 border-t border-slate-100">
                    <button type="button" @click="modalEdit = false" class="px-5 py-2 text-xs font-bold text-slate-700 bg-slate-100 rounded-xl">Batal</button>
                    <button type="submit" class="px-5 py-2 text-xs font-bold text-white bg-slate-900 hover:bg-slate-800 rounded-xl shadow">Update Beasiswa</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
