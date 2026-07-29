@extends('layouts.app')

@section('title', 'Login Admin')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center py-12 px-4">
    <div class="max-w-md w-full glass-card rounded-3xl p-8 border border-slate-200 shadow-xl relative overflow-hidden">
        <div class="text-center mb-8">
            <div class="h-20 w-auto flex items-center justify-center mx-auto mb-4">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Logo IKA SMAN Kajuara / IKA SMAN 8 BONE" class="h-20 w-auto object-contain">
            </div>
            <h2 class="font-heading font-extrabold text-2xl text-slate-900">Login Admin IKA</h2>
            <p class="text-xs text-slate-500 mt-1">Masuk untuk mengelola data alumni, berita, dan galeri.</p>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-semibold">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-xs font-semibold space-y-1">
                @foreach($errors->all() as $error)
                    <p><i class="fa-solid fa-triangle-exclamation mr-1"></i>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Username</label>
                <input type="text" name="username" value="{{ old('username') }}" required placeholder="Username admin..." class="w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-800">
            </div>

            <div x-data="{ showPassword: false }">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Password</label>
                <div class="relative">
                    <input :type="showPassword ? 'text' : 'password'" name="password" required placeholder="••••••••" class="w-full pl-4 pr-12 py-3 bg-slate-50 border border-slate-300 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-800">
                    <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600 transition focus:outline-none" title="Lihat Password">
                        <i class="fa-solid" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="w-full py-3.5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-sm rounded-xl shadow-lg transition">
                <i class="fa-solid fa-right-to-bracket mr-2 text-amber-400"></i>Masuk Ke Panel Admin
            </button>
        </form>
    </div>
</div>
@endsection
