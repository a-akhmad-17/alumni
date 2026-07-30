@extends('layouts.admin_layout')

@section('title', 'Manajemen Alumni - Dasbor Internal')

<div class="space-y-6" x-data="{
    modalTambah: false,
    modalEdit: false,
    modalImport: false,
    editAlumniData: {},
    selectedIds: [],
    allIds: @js($alumniList->pluck('id')->toArray()),
    toggleSelectAll(e) {
        if (e.target.checked) {
            this.selectedIds = [...this.allIds];
        } else {
            this.selectedIds = [];
        }
    },
    get isAllSelected() {
        return this.allIds.length > 0 && this.selectedIds.length === this.allIds.length;
    }
}">
    <!-- Header Card & Export/Import Action Bar -->
    <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-sm flex flex-col lg:flex-row lg:items-center justify-between gap-4">
        <div>
            <div class="flex items-center space-x-2 mb-1">
                <span class="text-xs uppercase font-bold text-amber-600 tracking-wider">Manajemen Database</span>
                @if($pendingCount > 0)
                    <span class="px-2.5 py-0.5 rounded-full bg-rose-600 text-white font-extrabold text-[10px] animate-pulse">
                        <i class="fa-solid fa-bell mr-1"></i>{{ $pendingCount }} Pendaftaran Pending
                    </span>
                @endif
            </div>
            <h1 class="font-heading font-extrabold text-2xl text-slate-900">Data Alumni IKA SMAN Kajuara / IKA SMAN 8 Bone</h1>
            <p class="text-xs text-slate-500 mt-1">Kelola, verifikasi pendaftaran baru, impor/ekspor data massal (Excel/PDF), edit & tandai alumni inspiratif.</p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <!-- Download Excel Button -->
            <a href="{{ route('admin.alumni.exportExcel', request()->all()) }}" class="px-4 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold rounded-xl transition flex items-center shadow-sm">
                <i class="fa-solid fa-file-excel mr-1.5 text-amber-300"></i>Ekspor Excel
            </a>

            <!-- Download PDF Report Button -->
            <a href="{{ route('admin.alumni.exportPdf', request()->all()) }}" target="_blank" class="px-4 py-2.5 bg-slate-800 hover:bg-slate-900 text-white text-xs font-bold rounded-xl transition flex items-center shadow-sm">
                <i class="fa-solid fa-file-pdf mr-1.5 text-rose-400"></i>Cetak PDF
            </a>

            <!-- Import Alumni Massal Button -->
            <button @click="modalImport = true" class="px-4 py-2.5 bg-amber-500 hover:bg-amber-600 text-slate-950 font-extrabold text-xs rounded-xl transition flex items-center shadow-sm">
                <i class="fa-solid fa-file-import mr-1.5"></i>Impor Massal
            </button>

            <!-- Tambah Manual Button -->
            <button @click="modalTambah = true" class="px-4 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-xl shadow-sm transition flex items-center">
                <i class="fa-solid fa-user-plus mr-1.5 text-amber-400"></i>+ Tambah Manual
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center space-x-2">
            <i class="fa-solid fa-circle-check text-emerald-600 text-sm"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold flex items-center space-x-2">
            <i class="fa-solid fa-triangle-exclamation text-rose-600 text-sm"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- 📊 MODAL PRATINJAU & VALIDASI DATA IMPOR ALUMNI (Jika file diupload) -->
    @if(session('import_preview_ready') && session('import_preview_rows'))
        <div class="p-6 bg-amber-50 border-2 border-amber-300 rounded-3xl space-y-4 shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <span class="px-3 py-1 bg-amber-200 text-amber-900 text-[10px] font-black uppercase rounded-full border border-amber-400">Pratinjau Impor Data</span>
                    <h3 class="font-heading font-extrabold text-lg text-slate-900 mt-1">Validasi Hasil Pembacaan File Excel/CSV</h3>
                    <p class="text-xs text-slate-600">Periksa kembali data di bawah ini sebelum dimasukkan ke database utama.</p>
                </div>

                <div class="flex items-center space-x-2">
                    <form action="{{ route('admin.alumni.processImport') }}" method="POST">
                        @csrf
                        <button type="submit" class="px-6 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-extrabold text-xs rounded-xl shadow-md transition flex items-center">
                            <i class="fa-solid fa-cloud-arrow-up mr-2 text-emerald-400"></i>Simpan {{ count(session('import_preview_rows')) }} Data Ke Database
                        </button>
                    </form>
                </div>
            </div>

            <div class="overflow-x-auto max-h-72 bg-white rounded-2xl border border-slate-300">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-100 font-bold uppercase text-slate-600 border-b border-slate-200 sticky top-0">
                        <tr>
                            <th class="p-2.5">No</th>
                            <th class="p-2.5">Nama Lengkap</th>
                            <th class="p-2.5">Gender</th>
                            <th class="p-2.5">Angkatan</th>
                            <th class="p-2.5">Profesi</th>
                            <th class="p-2.5">Domisili</th>
                            <th class="p-2.5">No. WhatsApp</th>
                            <th class="p-2.5">Status Duplikasi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach(session('import_preview_rows') as $idx => $r)
                            <tr class="{{ $r['is_duplicate'] ? 'bg-amber-50/70' : 'hover:bg-slate-50' }}">
                                <td class="p-2.5 font-bold">{{ $idx + 1 }}</td>
                                <td class="p-2.5 font-semibold text-slate-900">{{ $r['nama'] }}</td>
                                <td class="p-2.5">{{ $r['jenis_kelamin'] }}</td>
                                <td class="p-2.5 font-bold">{{ $r['angkatan'] }}</td>
                                <td class="p-2.5">{{ $r['profesi'] }}</td>
                                <td class="p-2.5">{{ $r['domisili'] }}</td>
                                <td class="p-2.5 font-semibold">{{ $r['no_hp'] }}</td>
                                <td class="p-2.5">
                                    @if($r['is_duplicate'])
                                        <span class="px-2 py-0.5 rounded-full bg-amber-200 text-amber-900 font-extrabold text-[10px]">
                                            <i class="fa-solid fa-triangle-exclamation mr-1"></i>Nama Terdeteksi Ada di Database
                                        </span>
                                    @else
                                        <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 font-bold text-[10px]">
                                            <i class="fa-solid fa-check mr-1"></i>Data Baru
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- Main Data Table Card -->
    <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm space-y-4">
        <!-- Status Filter Tabs -->
        <div class="flex flex-wrap items-center gap-2 border-b border-slate-200 pb-4">
            <a href="{{ route('admin.alumni') }}" class="px-4 py-2 rounded-xl text-xs font-bold transition {{ !request('status') || request('status') == 'semua' ? 'bg-slate-900 text-white shadow-sm' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                Semua Data
            </a>
            <a href="{{ route('admin.alumni', array_merge(request()->except('status'), ['status' => 'pending'])) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition {{ request('status') == 'pending' ? 'bg-rose-600 text-white shadow-sm' : 'bg-rose-50 text-rose-700 hover:bg-rose-100 border border-rose-200' }} flex items-center">
                <i class="fa-solid fa-clock mr-1.5"></i>Menunggu Verifikasi (Pending)
                @if($pendingCount > 0)
                    <span class="ml-1.5 px-1.5 py-0.2 rounded-full bg-white text-rose-700 font-extrabold text-[10px]">{{ $pendingCount }}</span>
                @endif
            </a>
            <a href="{{ route('admin.alumni', array_merge(request()->except('status'), ['status' => 'approved'])) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition {{ request('status') == 'approved' ? 'bg-emerald-700 text-white shadow-sm' : 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-200' }}">
                Disetujui (Approved)
            </a>
            <a href="{{ route('admin.alumni', array_merge(request()->except('status'), ['status' => 'rejected'])) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition {{ request('status') == 'rejected' ? 'bg-slate-700 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Ditolak (Rejected)
            </a>
        </div>

        <!-- Comprehensive Multi-Filter Bar -->
        <form action="{{ route('admin.alumni') }}" method="GET" class="p-4 bg-slate-50 border border-slate-200 rounded-2xl space-y-3">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
                <!-- Search Input -->
                <div class="lg:col-span-2 relative">
                    <label class="block text-[10px] font-bold uppercase text-slate-500 mb-1">Pencarian Nama / Profesi / No HP</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                            <i class="fa-solid fa-search text-xs"></i>
                        </span>
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama, profesi, domisili, WA..." class="w-full pl-9 pr-3 py-2 bg-white border border-slate-300 rounded-xl text-xs text-slate-900 focus:outline-none focus:border-slate-900">
                    </div>
                </div>

                <!-- Filter Angkatan -->
                <div>
                    <label class="block text-[10px] font-bold uppercase text-slate-500 mb-1">Angkatan</label>
                    <select name="angkatan" class="w-full px-3 py-2 bg-white border border-slate-300 rounded-xl text-xs text-slate-900 focus:outline-none focus:border-slate-900">
                        <option value="">Semua Angkatan</option>
                        @foreach($angkatanList as $thn)
                            <option value="{{ $thn }}" {{ request('angkatan') == $thn ? 'selected' : '' }}>Angkatan {{ $thn }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Domisili -->
                <div>
                    <label class="block text-[10px] font-bold uppercase text-slate-500 mb-1">Domisili Kota</label>
                    <select name="domisili" class="w-full px-3 py-2 bg-white border border-slate-300 rounded-xl text-xs text-slate-900 focus:outline-none focus:border-slate-900">
                        <option value="">Semua Kota</option>
                        @foreach($domisiliList as $dom)
                            <option value="{{ $dom }}" {{ request('domisili') == $dom ? 'selected' : '' }}>{{ $dom }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Gender -->
                <div>
                    <label class="block text-[10px] font-bold uppercase text-slate-500 mb-1">Gender</label>
                    <select name="gender" class="w-full px-3 py-2 bg-white border border-slate-300 rounded-xl text-xs text-slate-900 focus:outline-none focus:border-slate-900">
                        <option value="">Semua Gender</option>
                        <option value="Laki-laki" {{ request('gender') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ request('gender') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
            </div>

            <!-- Action Filter Row -->
            <div class="flex items-center justify-between pt-2 border-t border-slate-200">
                <label class="flex items-center space-x-2 cursor-pointer">
                    <input type="checkbox" name="is_berprestasi" value="1" {{ request('is_berprestasi') == '1' ? 'checked' : '' }} class="w-4 h-4 text-amber-600 rounded border-slate-300 focus:ring-amber-500">
                    <span class="text-xs font-bold text-slate-700">
                        <i class="fa-solid fa-star text-amber-500 mr-1"></i>Hanya Tampilkan Alumni Berprestasi ⭐
                    </span>
                </label>

                <div class="flex items-center space-x-2">
                    @if(request()->hasAny(['q', 'angkatan', 'domisili', 'gender', 'is_berprestasi', 'status']))
                        <a href="{{ route('admin.alumni') }}" class="px-3 py-2 bg-slate-200 text-slate-700 hover:bg-slate-300 text-xs font-semibold rounded-xl transition flex items-center">
                            <i class="fa-solid fa-rotate-left mr-1"></i>Reset Filter
                        </a>
                    @endif
                    <button type="submit" class="px-5 py-2 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-xl shadow-md transition flex items-center">
                        <i class="fa-solid fa-filter mr-1.5 text-amber-400"></i>Terapkan Filter
                    </button>
                </div>
            </div>
        </form>

        <!-- Floating Bulk Action Bar -->
        <div x-show="selectedIds.length > 0" x-transition.opacity class="p-4 bg-slate-900 text-white rounded-2xl shadow-xl flex flex-col sm:flex-row sm:items-center justify-between gap-3 border border-slate-800">
            <div class="flex items-center space-x-3">
                <span class="w-8 h-8 rounded-xl bg-amber-500 text-slate-950 font-black text-sm flex items-center justify-center shadow-sm" x-text="selectedIds.length"></span>
                <div>
                    <h4 class="font-bold text-sm text-white">Data Alumni Terpilih</h4>
                    <p class="text-xs text-slate-400">Pilih aksi masal untuk data alumni yang anda centang di tabel</p>
                </div>
            </div>

            <div class="flex items-center space-x-2">
                <button type="button" @click="selectedIds = []" class="px-3 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 font-semibold text-xs rounded-xl transition">
                    Batal Pilih
                </button>

                <form action="{{ route('admin.alumni.bulkDelete') }}" method="POST" onsubmit="return confirm('Apakah Boss yakin ingin MENGHAPUS SEMUA (' + selectedIds.length + ') data alumni terpilih ini? Data yang dihapus tidak dapat dikembalikan.')">
                    @csrf
                    @method('DELETE')
                    <template x-for="id in selectedIds" :key="id">
                        <input type="hidden" name="ids[]" :value="id">
                    </template>
                    <button type="submit" class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white font-extrabold text-xs rounded-xl shadow-md transition flex items-center">
                        <i class="fa-solid fa-trash mr-1.5"></i>Hapus <span class="mx-1" x-text="selectedIds.length"></span> Terpilih
                    </button>
                </form>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-700">
                <thead class="bg-slate-50 text-xs uppercase font-bold text-slate-500 border-b border-slate-200">
                    <tr>
                        <th class="p-3 w-10 text-center">
                            <input type="checkbox" :checked="isAllSelected" @change="toggleSelectAll($event)" class="w-4 h-4 text-amber-600 rounded border-slate-300 focus:ring-amber-500 cursor-pointer" title="Pilih Semua di Halaman Ini">
                        </th>
                        <th class="p-3">Foto</th>
                        <th class="p-3">Nama Lengkap</th>
                        <th class="p-3">Angkatan</th>
                        <th class="p-3">Profesi / Pekerjaan</th>
                        <th class="p-3">No. WhatsApp / HP</th>
                        <th class="p-3">Status Verifikasi</th>
                        <th class="p-3 text-center">Aksi & Persetujuan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($alumniList as $alm)
                        <tr class="hover:bg-slate-50 transition" :class="selectedIds.includes(@js($alm->id)) ? 'bg-amber-50/60' : ''">
                            <td class="p-3 text-center">
                                <input type="checkbox" :value="@js($alm->id)" x-model="selectedIds" class="w-4 h-4 text-amber-600 rounded border-slate-300 focus:ring-amber-500 cursor-pointer">
                            </td>
                            <td class="p-3">
                                @if($alm->foto)
                                    <img src="{{ asset($alm->foto) }}" alt="{{ $alm->nama }}" class="w-10 h-10 rounded-full object-cover border border-slate-200 shadow-sm">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-slate-900 text-amber-400 flex items-center justify-center font-bold text-xs shadow-sm">
                                        {{ substr($alm->nama, 0, 2) }}
                                    </div>
                                @endif
                            </td>
                            <td class="p-3">
                                <div class="font-semibold text-slate-900">{{ $alm->nama }}</div>
                                <div class="text-[11px] text-slate-400">{{ $alm->email ?? 'Tanpa email' }}</div>
                            </td>
                            <td class="p-3"><span class="px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-800 text-xs font-bold border border-slate-200">{{ $alm->angkatan }}</span></td>
                            <td class="p-3">
                                <div class="font-semibold text-slate-800">{{ $alm->profesi ?? '-' }}</div>
                                <div class="text-xs text-slate-500"><i class="fa-solid fa-location-dot mr-1 text-[10px]"></i>{{ $alm->domisili ?? '-' }}</div>
                            </td>
                            <td class="p-3 font-semibold text-slate-900">{{ $alm->no_hp ?? '-' }}</td>
                            <td class="p-3">
                                @if($alm->status == 'approved' || empty($alm->status))
                                    <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-900 border border-emerald-300 text-[10px] font-extrabold uppercase inline-block">
                                        <i class="fa-solid fa-circle-check mr-1 text-emerald-600"></i>Terverifikasi
                                    </span>
                                @elseif($alm->status == 'pending')
                                    <span class="px-2.5 py-0.5 rounded-full bg-rose-100 text-rose-900 border border-rose-300 text-[10px] font-extrabold uppercase inline-block animate-pulse">
                                        <i class="fa-solid fa-clock mr-1 text-rose-600"></i>Menunggu Verifikasi
                                    </span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full bg-slate-200 text-slate-700 text-[10px] font-extrabold uppercase inline-block">
                                        <i class="fa-solid fa-ban mr-1"></i>Ditolak
                                    </span>
                                @endif

                                @if($alm->is_berprestasi)
                                    <span class="mt-1 px-2.5 py-0.5 rounded-full bg-amber-100 text-amber-900 border border-amber-300 text-[9px] font-extrabold uppercase block w-max">
                                        <i class="fa-solid fa-star text-amber-500 mr-0.5"></i>Berprestasi
                                    </span>
                                @endif
                            </td>
                            <td class="p-3">
                                <div class="flex items-center justify-center space-x-1.5">
                                    <!-- Approval Buttons if Pending -->
                                    @if($alm->status == 'pending')
                                        <form action="{{ route('admin.alumni.approve', $alm->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" title="Setujui (Approve) Alumni ini" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-bold transition shadow-sm flex items-center">
                                                <i class="fa-solid fa-check mr-1"></i> Setujui
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.alumni.reject', $alm->id) }}" method="POST" onsubmit="return confirm('Tolak pendaftaran alumni ini?')">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" title="Tolak Pendaftaran" class="px-3 py-1.5 bg-slate-200 text-slate-700 hover:bg-slate-300 rounded-lg text-xs font-bold transition flex items-center">
                                                <i class="fa-solid fa-xmark mr-1"></i> Tolak
                                            </button>
                                        </form>
                                    @else
                                        <button @click="modalEdit = true; editAlumniData = @js($alm)" class="px-3 py-1.5 bg-amber-50 text-amber-700 hover:bg-amber-600 hover:text-white rounded-lg text-xs font-bold transition border border-amber-200 flex items-center">
                                            <i class="fa-solid fa-pen-to-square mr-1"></i> Edit
                                        </button>
                                        <form action="{{ route('admin.alumni.delete', $alm->id) }}" method="POST" onsubmit="return confirm('Apakah Boss yakin ingin menghapus data alumni {{ $alm->nama }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1.5 bg-red-50 text-red-600 hover:bg-red-600 hover:text-white rounded-lg text-xs font-bold transition border border-red-200 flex items-center">
                                                <i class="fa-solid fa-trash mr-1"></i> Hapus
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-8 text-center text-slate-400 italic">Belum ada data alumni yang sesuai filter.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="pt-4">
            {{ $alumniList->links() }}
        </div>
    </div>

    <!-- Modal Impor Alumni Massal -->
    <div x-show="modalImport" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-md p-4 overflow-y-auto" style="display: none;">
        <div @click.away="modalImport = false" class="bg-white rounded-3xl p-6 sm:p-8 max-w-lg w-full border border-slate-200 shadow-2xl relative my-8">
            <button @click="modalImport = false" class="absolute top-4 right-4 text-slate-400 hover:text-slate-900"><i class="fa-solid fa-xmark text-xl"></i></button>

            <h3 class="font-heading font-extrabold text-xl text-slate-900 mb-2 flex items-center">
                <i class="fa-solid fa-file-import text-amber-500 mr-2"></i>Impor Data Alumni Massal
            </h3>
            <p class="text-xs text-slate-500 mb-6">Unggah file Excel / CSV berisi daftar ribuan alumni sekaligus. Gunakan format template resmi agar data terbaca dengan tepat.</p>

            <!-- Download Template Box -->
            <div class="mb-6 p-4 bg-amber-50 border border-amber-200 rounded-2xl flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <i class="fa-solid fa-file-csv text-2xl text-amber-600"></i>
                    <div>
                        <div class="text-xs font-bold text-slate-900">Template Standar (.csv / .xlsx)</div>
                        <div class="text-[11px] text-slate-500">Format kolom: Nama, Gender, Angkatan, Profesi, Kota, WA, Email</div>
                    </div>
                </div>
                <a href="{{ route('admin.alumni.downloadTemplate') }}" class="px-3 py-1.5 bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs rounded-xl shadow-sm transition shrink-0">
                    <i class="fa-solid fa-download mr-1"></i>Unduh Template
                </a>
            </div>

            <form action="{{ route('admin.alumni.previewImport') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Pilih File Impor (.xlsx / .csv)</label>
                    <input type="file" name="file_import" required accept=".csv, .xlsx, .xls, .txt" class="w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-900 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-slate-900 file:text-white">
                </div>

                <div class="pt-4 flex justify-end space-x-3">
                    <button type="button" @click="modalImport = false" class="px-5 py-2.5 bg-slate-100 text-slate-700 text-sm font-semibold rounded-xl border border-slate-300">Batal</button>
                    <button type="submit" class="px-6 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-sm rounded-xl shadow-md flex items-center">
                        <i class="fa-solid fa-magnifying-glass mr-2 text-amber-400"></i>Pratinjau & Validasi Data
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Tambah Alumni Manual -->
    <div x-show="modalTambah" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-md p-4 overflow-y-auto" style="display: none;">
        <div @click.away="modalTambah = false" class="bg-white rounded-3xl p-6 sm:p-8 max-w-lg w-full border border-slate-200 shadow-2xl relative my-8">
            <button @click="modalTambah = false" class="absolute top-4 right-4 text-slate-400 hover:text-slate-900"><i class="fa-solid fa-xmark text-xl"></i></button>

            <h3 class="font-heading font-extrabold text-xl text-slate-900 mb-6 flex items-center">
                <i class="fa-solid fa-user-plus text-amber-500 mr-2"></i>Tambah Data Alumni Manual
            </h3>

            <form action="{{ route('admin.alumni.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Lengkap & Gelar *</label>
                        <input type="text" name="nama" required placeholder="Dr. H. Nama Alumni..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-900">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-900">
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Angkatan *</label>
                        <input type="number" name="angkatan" required min="1970" max="2030" placeholder="2015" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-900">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Domisili Kota</label>
                        <input type="text" name="domisili" placeholder="Makassar/Jakarta..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-900">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Kategori Sektor Profesi</label>
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
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Detail Jabatan Pekerjaan</label>
                        <input type="text" name="profesi" placeholder="Dokter / Perwira / CEO / Dosen..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-900">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">No. WhatsApp / HP</label>
                        <input type="text" name="no_hp" placeholder="0812..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-900">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Foto Profil (Auto WebP)</label>
                        <input type="file" name="foto" accept="image/*" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-900 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-slate-900 file:text-white">
                    </div>
                </div>

                <div class="p-4 bg-amber-50 border border-amber-200 rounded-2xl space-y-3">
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="checkbox" name="is_berprestasi" value="1" class="w-4 h-4 text-amber-600 rounded border-slate-300 focus:ring-amber-500">
                        <span class="text-xs font-bold text-amber-900 uppercase tracking-wider">
                            <i class="fa-solid fa-star text-amber-500 mr-1"></i>Tampilkan sebagai Alumni Berprestasi di Beranda
                        </span>
                    </label>
                    <div>
                        <label class="block text-[11px] font-bold text-amber-800 uppercase tracking-wider mb-1">Catatan Prestasi / Pencapaian</label>
                        <input type="text" name="deskripsi_prestasi" placeholder="Misal: Peraih Beasiswa LN / Tokoh Pengusaha..." class="w-full px-3 py-2 bg-white border border-amber-300 rounded-xl text-xs text-slate-900 focus:outline-none focus:border-slate-900">
                    </div>
                </div>

                <div class="pt-4 flex justify-end space-x-3">
                    <button type="button" @click="modalTambah = false" class="px-5 py-2.5 bg-slate-100 text-slate-700 text-sm font-semibold rounded-xl border border-slate-300">Batal</button>
                    <button type="submit" class="px-6 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-sm rounded-xl shadow-md">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Alumni -->
    <div x-show="modalEdit" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-md p-4 overflow-y-auto" style="display: none;">
        <div @click.away="modalEdit = false" class="bg-white rounded-3xl p-6 sm:p-8 max-w-lg w-full border border-slate-200 shadow-2xl relative my-8">
            <button @click="modalEdit = false" class="absolute top-4 right-4 text-slate-400 hover:text-slate-900"><i class="fa-solid fa-xmark text-xl"></i></button>

            <h3 class="font-heading font-extrabold text-xl text-slate-900 mb-6 flex items-center">
                <i class="fa-solid fa-user-pen text-amber-500 mr-2"></i>Edit Data Alumni
            </h3>

            <form :action="'{{ url('/admin/alumni') }}/' + editAlumniData.id" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Lengkap & Gelar *</label>
                        <input type="text" name="nama" x-model="editAlumniData.nama" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-900">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Jenis Kelamin</label>
                        <select name="jenis_kelamin" x-model="editAlumniData.jenis_kelamin" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-900">
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Angkatan *</label>
                        <input type="number" name="angkatan" x-model="editAlumniData.angkatan" required min="1970" max="2030" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-900">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Domisili Kota</label>
                        <input type="text" name="domisili" x-model="editAlumniData.domisili" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-900">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Kategori Sektor Profesi</label>
                        <select name="kategori_profesi" x-model="editAlumniData.kategori_profesi" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-900">
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
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Detail Jabatan Pekerjaan</label>
                        <input type="text" name="profesi" x-model="editAlumniData.profesi" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-900">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">No. WhatsApp / HP</label>
                        <input type="text" name="no_hp" x-model="editAlumniData.no_hp" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-900">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Ganti Foto Profil (Opsional)</label>
                        <input type="file" name="foto" accept="image/*" class="w-full px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-900 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-slate-900 file:text-white">
                    </div>
                </div>

                <div class="p-4 bg-amber-50 border border-amber-200 rounded-2xl space-y-3">
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="checkbox" name="is_berprestasi" value="1" :checked="editAlumniData.is_berprestasi == 1" class="w-4 h-4 text-amber-600 rounded border-slate-300 focus:ring-amber-500">
                        <span class="text-xs font-bold text-amber-900 uppercase tracking-wider">
                            <i class="fa-solid fa-star text-amber-500 mr-1"></i>Tampilkan sebagai Alumni Berprestasi di Beranda
                        </span>
                    </label>
                    <div>
                        <label class="block text-[11px] font-bold text-amber-800 uppercase tracking-wider mb-1">Catatan Prestasi / Pencapaian</label>
                        <input type="text" name="deskripsi_prestasi" x-model="editAlumniData.deskripsi_prestasi" placeholder="Misal: Peraih Beasiswa LN / Tokoh Pengusaha..." class="w-full px-3 py-2 bg-white border border-amber-300 rounded-xl text-xs text-slate-900 focus:outline-none focus:border-slate-900">
                    </div>
                </div>

                <div class="pt-4 flex justify-end space-x-3">
                    <button type="button" @click="modalEdit = false" class="px-5 py-2.5 bg-slate-100 text-slate-700 text-sm font-semibold rounded-xl border border-slate-300">Batal</button>
                    <button type="submit" class="px-6 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-sm rounded-xl shadow-md">Perbarui Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
