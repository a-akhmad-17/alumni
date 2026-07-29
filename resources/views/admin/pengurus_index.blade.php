@extends('layouts.admin_layout')

@section('title', 'Manajemen Pengurus - Dasbor Internal')

@section('content')
<div class="space-y-6" x-data="{ modalTambah: false, modalEdit: false, editData: {} }">
    <!-- Header Card -->
    <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <span class="text-xs uppercase font-bold text-amber-600 tracking-wider block mb-1">Manajemen Halaman Publik</span>
            <h1 class="font-heading font-extrabold text-2xl text-slate-900">Struktur Pengurus Pusat & Bidang</h1>
            <p class="text-xs text-slate-500 mt-1">Kelola Pengurus Inti (Ketua Umum, Ketua Harian, Sekum, Wasek, Bendum, Wabendum), 8 Bidang, dan Koordinator Angkatan.</p>
        </div>

        <button @click="modalTambah = true" class="px-6 py-3 bg-slate-900 hover:bg-slate-800 text-white font-bold text-sm rounded-xl shadow-md transition flex items-center justify-center shrink-0">
            <i class="fa-solid fa-user-plus mr-2 text-amber-400"></i>Tambah Pengurus Baru
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
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-700">
                <thead class="bg-slate-50 text-xs uppercase font-bold text-slate-500 border-b border-slate-200">
                    <tr>
                        <th class="p-3">Foto</th>
                        <th class="p-3">Nama Pengurus</th>
                        <th class="p-3">Jabatan Resmi</th>
                        <th class="p-3">Bidang Organisasi</th>
                        <th class="p-3">Kategori</th>
                        <th class="p-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($pengurusList as $png)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="p-3">
                                @if($png->foto)
                                    <img src="{{ asset($png->foto) }}" alt="{{ $png->nama }}" class="w-10 h-10 rounded-full object-cover border border-slate-200 shadow-sm">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-slate-900 text-amber-400 flex items-center justify-center font-bold text-xs shadow-sm">
                                        {{ substr($png->nama, 0, 2) }}
                                    </div>
                                @endif
                            </td>
                            <td class="p-3 font-semibold text-slate-900">{{ $png->nama }}</td>
                            <td class="p-3 font-semibold text-amber-700">{{ $png->jabatan }}</td>
                            <td class="p-3 text-xs text-slate-600">{{ $png->bidang->nama_bidang ?? 'Pengurus Inti' }}</td>
                            <td class="p-3">
                                @if($png->is_inti)
                                    <span class="px-2.5 py-0.5 rounded-full bg-slate-900 text-amber-400 text-[10px] font-bold shadow-sm">Pengurus Inti</span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-700 text-[10px] font-bold border border-slate-200">Bidang / Koordinator</span>
                                @endif
                            </td>
                            <td class="p-3 flex items-center justify-center space-x-2">
                                <button @click="editData = @js($png); modalEdit = true" class="px-3 py-1.5 bg-amber-50 text-amber-700 hover:bg-amber-600 hover:text-white rounded-lg text-xs font-bold transition border border-amber-200 flex items-center">
                                    <i class="fa-solid fa-pen-to-square mr-1"></i> Edit
                                </button>
                                <form action="{{ route('admin.pengurus.delete', $png->id) }}" method="POST" onsubmit="return confirm('Apakah Boss yakin ingin menghapus data pengurus {{ $png->nama }}?')">
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
                            <td colspan="6" class="p-8 text-center text-slate-400 italic">Belum ada data pengurus.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Tambah Pengurus (Upload Foto HP/Laptop & Auto WebP) -->
    <div x-show="modalTambah" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-md p-4 overflow-y-auto" style="display: none;">
        <div @click.away="modalTambah = false" class="bg-white rounded-3xl p-6 sm:p-8 max-w-lg w-full border border-slate-200 shadow-2xl relative my-8">
            <button @click="modalTambah = false" class="absolute top-4 right-4 text-slate-400 hover:text-slate-900"><i class="fa-solid fa-xmark text-xl"></i></button>

            <h3 class="font-heading font-extrabold text-xl text-slate-900 mb-6 flex items-center">
                <i class="fa-solid fa-user-plus text-amber-500 mr-2"></i>Tambah Pengurus Baru
            </h3>

            <form action="{{ route('admin.pengurus.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Lengkap & Gelar *</label>
                    <input type="text" name="nama" required placeholder="Dr. H. Nama Pengurus, M.Si." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-900">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Jabatan Resmi *</label>
                        <input type="text" name="jabatan" required placeholder="Ketua Umum / Sekum / Bendum..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-900">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Bidang Organisasi *</label>
                        <select name="id_bidang" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-900">
                            @foreach($bidangList as $bdg)
                                <option value="{{ $bdg->id }}">{{ $bdg->nama_bidang }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Status Pengurus *</label>
                        <select name="is_inti" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-900">
                            <option value="1">Pengurus Inti</option>
                            <option value="0">Pengurus Bidang / Koordinator</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Upload Foto Profil</label>
                        <input type="file" name="foto" accept="image/*" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-900 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-slate-900 file:text-white">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Username Instagram</label>
                        <input type="text" name="sosmed_instagram" placeholder="https://instagram.com/username" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-900">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">LinkedIn Profile</label>
                        <input type="text" name="sosmed_linkedin" placeholder="https://linkedin.com/in/username" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-900">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Deskripsi Tugas / Peran</label>
                    <textarea name="deskripsi_tugas" rows="2" placeholder="Penjelasan tugas pengurus..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-900"></textarea>
                </div>

                <div class="pt-4 flex justify-end space-x-3">
                    <button type="button" @click="modalTambah = false" class="px-5 py-2.5 bg-slate-100 text-slate-700 text-sm font-semibold rounded-xl border border-slate-300">Batal</button>
                    <button type="submit" class="px-6 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-sm rounded-xl shadow-md">Simpan Pengurus</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Pengurus -->
    <div x-show="modalEdit" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-md p-4 overflow-y-auto" style="display: none;">
        <div @click.away="modalEdit = false" class="bg-white rounded-3xl p-6 sm:p-8 max-w-lg w-full border border-slate-200 shadow-2xl relative my-8">
            <button @click="modalEdit = false" class="absolute top-4 right-4 text-slate-400 hover:text-slate-900"><i class="fa-solid fa-xmark text-xl"></i></button>

            <h3 class="font-heading font-extrabold text-xl text-slate-900 mb-6 flex items-center">
                <i class="fa-solid fa-user-pen text-amber-500 mr-2"></i>Edit Data Pengurus
            </h3>

            <form :action="'{{ url('/admin/pengurus') }}/' + editData.id" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Lengkap & Gelar *</label>
                    <input type="text" name="nama" x-model="editData.nama" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-900">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Jabatan Resmi *</label>
                        <input type="text" name="jabatan" x-model="editData.jabatan" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-900">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Bidang Organisasi *</label>
                        <select name="id_bidang" x-model="editData.id_bidang" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-900">
                            @foreach($bidangList as $bdg)
                                <option value="{{ $bdg->id }}">{{ $bdg->nama_bidang }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Status Pengurus *</label>
                        <select name="is_inti" x-model="editData.is_inti" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-900">
                            <option value="1">Pengurus Inti</option>
                            <option value="0">Pengurus Bidang / Koordinator</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Ganti Foto (Opsional)</label>
                        <input type="file" name="foto" accept="image/*" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-900 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-slate-900 file:text-white">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Instagram</label>
                        <input type="text" name="sosmed_instagram" x-model="editData.sosmed_instagram" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-900">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">LinkedIn</label>
                        <input type="text" name="sosmed_linkedin" x-model="editData.sosmed_linkedin" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-900">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Deskripsi Tugas / Peran</label>
                    <textarea name="deskripsi_tugas" x-model="editData.deskripsi_tugas" rows="2" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-900"></textarea>
                </div>

                <div class="pt-4 flex justify-end space-x-3">
                    <button type="button" @click="modalEdit = false" class="px-5 py-2.5 bg-slate-100 text-slate-700 text-sm font-semibold rounded-xl border border-slate-300">Batal</button>
                    <button type="submit" class="px-6 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-sm rounded-xl shadow-md">Perbarui Pengurus</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
