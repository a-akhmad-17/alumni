@extends('layouts.admin_layout')

@section('title', 'Manajemen Pengguna - Dasbor Internal')

@section('content')
<div class="space-y-6" x-data="{ modalTambah: false, modalEdit: false, editData: {}, showPasswordTambah: false, showPasswordEdit: false }">
    <!-- Header Card -->
    <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <span class="text-xs uppercase font-bold text-amber-600 tracking-wider block mb-1">Keamanan & Hak Akses</span>
            <h1 class="font-heading font-extrabold text-2xl text-slate-900">Manajemen Pengguna Admin</h1>
            <p class="text-xs text-slate-500 mt-1">Kelola akun administrator yang memiliki akses ke panel internal website alumni.</p>
        </div>

        <button @click="modalTambah = true" class="px-6 py-3 bg-slate-900 hover:bg-slate-800 text-white font-bold text-sm rounded-xl shadow-md transition flex items-center justify-center shrink-0">
            <i class="fa-solid fa-user-plus mr-2 text-amber-400"></i>Tambah Pengguna Baru
        </button>
    </div>

    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center space-x-2">
            <i class="fa-solid fa-circle-check text-emerald-600 text-sm"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="p-4 rounded-xl bg-red-50 border border-red-200 text-red-800 text-xs font-semibold flex items-center space-x-2">
            <i class="fa-solid fa-triangle-exclamation text-red-600 text-sm"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- Data Table Card -->
    <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm">
        <!-- Filter Header Bar -->
        <form method="GET" action="{{ route('admin.users') }}" class="mb-6 grid grid-cols-1 sm:grid-cols-12 gap-3">
            <div class="sm:col-span-8 relative">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama, username, atau email pengguna..." class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-900 focus:outline-none focus:border-slate-800">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3 text-slate-400 text-xs"></i>
            </div>
            <div class="sm:col-span-4 flex gap-2">
                <button type="submit" class="w-full py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-xl shadow-sm transition">
                    <i class="fa-solid fa-filter mr-1.5 text-amber-400"></i>Filter
                </button>
                @if(request()->filled('q'))
                    <a href="{{ route('admin.users') }}" class="px-3 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-bold transition flex items-center justify-center shrink-0" title="Reset Filter">
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
                        <th class="p-3">Nama Lengkap</th>
                        <th class="p-3">Username</th>
                        <th class="p-3">Email</th>
                        <th class="p-3">Role</th>
                        <th class="p-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($usersList as $idx => $usr)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="p-3 font-semibold text-xs text-slate-400">{{ $usersList->firstItem() + $idx }}</td>
                            <td class="p-3 font-bold text-slate-900 flex items-center space-x-3">
                                <div class="w-8 h-8 rounded-full bg-slate-900 text-amber-400 flex items-center justify-center font-bold text-xs">
                                    {{ strtoupper(substr($usr->full_name, 0, 1)) }}
                                </div>
                                <div>
                                    <span class="block font-bold text-slate-900">{{ $usr->full_name }}</span>
                                    @if(Auth::id() == $usr->id)
                                        <span class="text-[10px] text-emerald-600 font-bold uppercase">(Akun Anda Saat Ini)</span>
                                    @endif
                                </div>
                            </td>
                            <td class="p-3 text-xs font-mono text-slate-700 font-semibold">
                                {{ $usr->username }}
                            </td>
                            <td class="p-3 text-xs text-slate-500">
                                {{ $usr->email ?? '-' }}
                            </td>
                            <td class="p-3">
                                <span class="px-2.5 py-0.5 rounded-full bg-slate-900 text-white text-[10px] font-bold uppercase tracking-wider">
                                    {{ $usr->role ?? 'admin' }}
                                </span>
                            </td>
                            <td class="p-3 flex items-center justify-center space-x-2">
                                <button @click="editData = @js($usr); modalEdit = true" class="px-3 py-1.5 bg-amber-50 text-amber-700 hover:bg-amber-600 hover:text-white rounded-lg text-xs font-bold transition border border-amber-200 flex items-center">
                                    <i class="fa-solid fa-pen-to-square mr-1"></i> Edit
                                </button>
                                @if(Auth::id() != $usr->id)
                                    <form action="{{ route('admin.users.delete', $usr->id) }}" method="POST" onsubmit="return confirm('Apakah Boss yakin ingin menghapus akun pengguna ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 bg-red-50 text-red-600 hover:bg-red-600 hover:text-white rounded-lg text-xs font-bold transition border border-red-200 flex items-center">
                                            <i class="fa-solid fa-trash mr-1"></i> Hapus
                                        </button>
                                    </form>
                                @else
                                    <button disabled title="Tidak bisa menghapus akun sendiri" class="px-3 py-1.5 bg-slate-100 text-slate-400 rounded-lg text-xs font-bold border border-slate-200 cursor-not-allowed flex items-center">
                                        <i class="fa-solid fa-lock mr-1"></i> Hapus
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-400 italic">Belum ada pengguna admin yang terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="pt-4">
            {{ $usersList->links() }}
        </div>
    </div>

    <!-- Modal Tambah User -->
    <div x-show="modalTambah" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-md p-4 overflow-y-auto" style="display: none;">
        <div @click.away="modalTambah = false" class="bg-white rounded-3xl p-6 sm:p-8 max-w-lg w-full border border-slate-200 shadow-2xl relative my-8">
            <button @click="modalTambah = false" class="absolute top-4 right-4 text-slate-400 hover:text-slate-900"><i class="fa-solid fa-xmark text-xl"></i></button>

            <h3 class="font-heading font-extrabold text-xl text-slate-900 mb-6 flex items-center">
                <i class="fa-solid fa-user-plus text-amber-500 mr-2"></i>Tambah Akun Pengguna Baru
            </h3>

            <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Lengkap *</label>
                    <input type="text" name="full_name" required placeholder="Nama lengkap pengurus/admin..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-900">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Username Login *</label>
                        <input type="text" name="username" required placeholder="username..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-900">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Role / Peran *</label>
                        <select name="role" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-900">
                            <option value="admin">Administrator</option>
                            <option value="superadmin">Super Admin</option>
                            <option value="editor">Editor Berita</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Email (Opsional)</label>
                    <input type="email" name="email" placeholder="admin@example.com" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-900">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Password *</label>
                    <div class="relative">
                        <input :type="showPasswordTambah ? 'text' : 'password'" name="password" required placeholder="Minimal 6 karakter..." class="w-full pl-4 pr-12 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-900">
                        <button type="button" @click="showPasswordTambah = !showPasswordTambah" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600 transition focus:outline-none">
                            <i class="fa-solid" :class="showPasswordTambah ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                </div>

                <div class="pt-4 flex justify-end space-x-3 border-t border-slate-100">
                    <button type="button" @click="modalTambah = false" class="px-5 py-2.5 bg-slate-100 text-slate-700 text-sm font-semibold rounded-xl border border-slate-300">Batal</button>
                    <button type="submit" class="px-6 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-sm rounded-xl shadow-md">
                        <i class="fa-solid fa-save mr-1.5 text-amber-400"></i>Simpan Pengguna
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit User -->
    <div x-show="modalEdit" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-md p-4 overflow-y-auto" style="display: none;">
        <div @click.away="modalEdit = false" class="bg-white rounded-3xl p-6 sm:p-8 max-w-lg w-full border border-slate-200 shadow-2xl relative my-8">
            <button @click="modalEdit = false" class="absolute top-4 right-4 text-slate-400 hover:text-slate-900"><i class="fa-solid fa-xmark text-xl"></i></button>

            <h3 class="font-heading font-extrabold text-xl text-slate-900 mb-6 flex items-center">
                <i class="fa-solid fa-user-pen text-amber-500 mr-2"></i>Edit Pengguna Admin
            </h3>

            <form :action="'{{ url('/admin/users') }}/' + editData.id" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Lengkap *</label>
                    <input type="text" name="full_name" x-model="editData.full_name" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-900">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Username Login *</label>
                        <input type="text" name="username" x-model="editData.username" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-900">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Role / Peran *</label>
                        <select name="role" x-model="editData.role" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-900">
                            <option value="admin">Administrator</option>
                            <option value="superadmin">Super Admin</option>
                            <option value="editor">Editor Berita</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Email</label>
                    <input type="email" name="email" x-model="editData.email" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-900">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Ganti Password (Kosongkan jika tidak diubah)</label>
                    <div class="relative">
                        <input :type="showPasswordEdit ? 'text' : 'password'" name="password" placeholder="Isi hanya jika ingin meriset password..." class="w-full pl-4 pr-12 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-900">
                        <button type="button" @click="showPasswordEdit = !showPasswordEdit" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600 transition focus:outline-none">
                            <i class="fa-solid" :class="showPasswordEdit ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                </div>

                <div class="pt-4 flex justify-end space-x-3 border-t border-slate-100">
                    <button type="button" @click="modalEdit = false" class="px-5 py-2.5 bg-slate-100 text-slate-700 text-sm font-semibold rounded-xl border border-slate-300">Batal</button>
                    <button type="submit" class="px-6 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-sm rounded-xl shadow-md">
                        <i class="fa-solid fa-save mr-1.5 text-amber-400"></i>Perbarui Pengguna
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
