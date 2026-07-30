<header x-data="{ open: false }" class="fixed top-0 left-0 right-0 z-50 glass-header transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <!-- Logo & Brand -->
            <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                <div class="h-12 w-auto flex items-center justify-center group-hover:scale-105 transition-transform duration-300">
                    <img src="{{ asset('assets/images/logo.webp') }}" alt="Logo IKA SMAN Kajuara / SMAN 8 Bone" class="h-12 w-auto object-contain drop-shadow-sm">
                </div>
                <div>
                    <span class="font-heading font-extrabold text-base tracking-tight text-slate-900 block leading-tight">
                        IKA <span class="gradient-text-light">SMAN KAJUARA</span>
                    </span>
                    <span class="text-[11px] font-bold text-slate-500 block tracking-wider uppercase">
                        SMAN 8 BONE
                    </span>
                </div>
            </a>

            <!-- Desktop Navigation Links -->
            <nav class="hidden md:flex items-center space-x-1 lg:space-x-1.5">
                <a href="{{ route('home') }}" class="px-3.5 py-2 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('home') ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-700 hover:text-slate-900 hover:bg-slate-100' }}">
                    <i class="fa-solid fa-house mr-1.5 opacity-70"></i>Beranda
                </a>
                <a href="{{ route('profil') }}" class="px-3.5 py-2 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('profil') ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-700 hover:text-slate-900 hover:bg-slate-100' }}">
                    <i class="fa-solid fa-landmark mr-1.5 opacity-70"></i>Tentang Kami
                </a>
                <a href="{{ route('struktur') }}" class="px-3.5 py-2 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('struktur') ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-700 hover:text-slate-900 hover:bg-slate-100' }}">
                    <i class="fa-solid fa-sitemap mr-1.5 opacity-70"></i>Struktur
                </a>
                <a href="{{ route('alumni.index') }}" class="px-3.5 py-2 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('alumni.*') ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-700 hover:text-slate-900 hover:bg-slate-100' }}">
                    <i class="fa-solid fa-users mr-1.5 opacity-70"></i>Data Alumni
                </a>
                <a href="{{ route('kta.index') }}" class="px-3.5 py-2 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('kta.*') ? 'bg-amber-500 text-slate-950 font-bold shadow-md shadow-amber-500/20' : 'text-slate-700 hover:text-slate-900 hover:bg-amber-50' }}">
                    <i class="fa-solid fa-id-card mr-1.5 opacity-80 text-amber-600"></i>KTA Digital
                </a>
                <a href="{{ route('berita.index') }}" class="px-3.5 py-2 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('berita.*') ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-700 hover:text-slate-900 hover:bg-slate-100' }}">
                    <i class="fa-solid fa-newspaper mr-1.5 opacity-70"></i>Berita
                </a>
                <a href="{{ route('beasiswa.index') }}" class="px-3.5 py-2 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('beasiswa.*') ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-700 hover:text-slate-900 hover:bg-slate-100' }}">
                    <i class="fa-solid fa-graduation-cap mr-1.5 opacity-70"></i>Beasiswa
                </a>
                <a href="{{ route('galeri') }}" class="px-3.5 py-2 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('galeri') ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-700 hover:text-slate-900 hover:bg-slate-100' }}">
                    <i class="fa-solid fa-images mr-1.5 opacity-70"></i>Galeri
                </a>
            </nav>

            <!-- Action Buttons -->
            <div class="hidden lg:flex items-center space-x-3">
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider bg-slate-900 text-white hover:bg-slate-800 shadow-sm transition">
                        <i class="fa-solid fa-user-shield mr-1.5 text-amber-400"></i>Dashboard Admin
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider bg-slate-900 hover:bg-slate-800 text-white shadow-md transition-all duration-300">
                        <i class="fa-solid fa-right-to-bracket mr-1.5 text-amber-400"></i>Login
                    </a>
                @endauth
            </div>

            <!-- Mobile Menu Toggle Button -->
            <div class="md:hidden flex items-center">
                <button @click="open = !open" type="button" class="p-2 rounded-xl text-slate-700 hover:text-slate-900 hover:bg-slate-100 focus:outline-none">
                    <i x-show="!open" class="fa-solid fa-bars text-xl"></i>
                    <i x-show="open" class="fa-solid fa-xmark text-xl" style="display: none;"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Drawer Navigation -->
    <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" class="md:hidden bg-white border-b border-slate-200 px-4 pt-2 pb-6 space-y-2">
        <a href="{{ route('home') }}" class="block px-3 py-2.5 rounded-xl text-base font-semibold text-slate-800 hover:bg-slate-100"><i class="fa-solid fa-house w-6 text-slate-500"></i>Beranda</a>
        <a href="{{ route('profil') }}" class="block px-3 py-2.5 rounded-xl text-base font-semibold text-slate-800 hover:bg-slate-100"><i class="fa-solid fa-landmark w-6 text-slate-500"></i>Tentang Kami</a>
        <a href="{{ route('struktur') }}" class="block px-3 py-2.5 rounded-xl text-base font-semibold text-slate-800 hover:bg-slate-100"><i class="fa-solid fa-sitemap w-6 text-slate-500"></i>Struktur</a>
        <a href="{{ route('alumni.index') }}" class="block px-3 py-2.5 rounded-xl text-base font-semibold text-slate-800 hover:bg-slate-100"><i class="fa-solid fa-users w-6 text-slate-500"></i>Data Alumni</a>
        <a href="{{ route('kta.index') }}" class="block px-3 py-2.5 rounded-xl text-base font-bold text-amber-700 hover:bg-amber-50"><i class="fa-solid fa-id-card w-6 text-amber-500"></i>KTA Digital</a>
        <a href="{{ route('berita.index') }}" class="block px-3 py-2.5 rounded-xl text-base font-semibold text-slate-800 hover:bg-slate-100"><i class="fa-solid fa-newspaper w-6 text-slate-500"></i>Berita</a>
        <a href="{{ route('beasiswa.index') }}" class="block px-3 py-2.5 rounded-xl text-base font-semibold text-slate-800 hover:bg-slate-100"><i class="fa-solid fa-graduation-cap w-6 text-slate-500"></i>Beasiswa</a>
        <a href="{{ route('galeri') }}" class="block px-3 py-2.5 rounded-xl text-base font-semibold text-slate-800 hover:bg-slate-100"><i class="fa-solid fa-images w-6 text-slate-500"></i>Galeri</a>
        <div class="pt-4 border-t border-slate-200">
            @auth
                <a href="{{ route('admin.dashboard') }}" class="block text-center w-full py-3 rounded-xl font-bold bg-slate-900 text-white">Dashboard Admin</a>
            @else
                <a href="{{ route('login') }}" class="block text-center w-full py-3 rounded-xl font-bold bg-slate-900 text-white">Login</a>
            @endauth
        </div>
    </div>
</header>
