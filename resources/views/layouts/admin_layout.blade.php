<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dasbor Panel Internal') - IKA SMAN Kajuara / IKA SMAN 8 Bone</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        heading: ['Outfit', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    
    <!-- FontAwesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <!-- Alpine.js Interactivity -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- ApexCharts (selalu dibutuhkan di dashboard admin) -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts" defer></script>

    <style>
        .admin-sidebar-slate {
            background: linear-gradient(180deg, #0f172a 0%, #1e293b 60%, #0f172a 100%);
        }
        .admin-topbar-slate {
            background: linear-gradient(90deg, #0f172a 0%, #1e293b 100%);
            border-bottom: 1px solid rgba(226, 232, 240, 0.15);
        }
        /* Sidebar transition */
        #admin-sidebar {
            transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 font-sans antialiased min-h-screen"
      x-data="{ sidebarOpen: window.innerWidth >= 1024 }"
      @resize.window="sidebarOpen = window.innerWidth >= 1024">

    <!-- Mobile Overlay (click to close sidebar) -->
    <div x-show="sidebarOpen && window.innerWidth < 1024"
         x-transition:enter="transition-opacity ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="sidebarOpen = false"
         class="fixed inset-0 bg-slate-950/70 z-40 lg:hidden"
         style="display: none;">
    </div>

    <!-- FLEX WRAPPER -->
    <div class="flex min-h-screen">

        <!-- LEFT SIDEBAR -->
        <aside id="admin-sidebar"
               :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
               class="fixed lg:static top-0 left-0 h-full w-64 admin-sidebar-slate text-white flex flex-col shrink-0 min-h-screen shadow-2xl z-50 lg:translate-x-0">

            <!-- Logo & Header -->
            <div class="p-5 border-b border-slate-800 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="Logo IKA SMAN Kajuara" class="h-10 w-auto bg-white/10 p-1 rounded-lg">
                    <div>
                        <span class="font-heading font-extrabold text-xs uppercase tracking-wider block text-white">IKA SMAN KAJUARA</span>
                        <span class="text-[10px] text-amber-400 block uppercase font-semibold">SMAN 8 BONE</span>
                    </div>
                </div>
                <!-- Mobile Close Button -->
                <button @click="sidebarOpen = false" class="lg:hidden w-7 h-7 rounded-full bg-slate-800 text-slate-400 hover:text-white hover:bg-slate-700 flex items-center justify-center text-xs transition" aria-label="Tutup sidebar navigasi">
                    <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                </button>
            </div>

            <!-- User Profile Card -->
            <div class="p-4 border-b border-slate-800 flex items-center space-x-3 bg-slate-950/50">
                <div class="w-10 h-10 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center font-heading font-bold text-amber-400 text-lg shrink-0">
                    {{ substr(Auth::user()->full_name ?? 'Admin', 0, 1) }}
                </div>
                <div class="min-w-0">
                    <span class="font-bold text-sm text-white block truncate">{{ Auth::user()->full_name ?? 'Admin' }}</span>
                    <span class="px-2 py-0.5 rounded-full bg-slate-800 text-slate-300 text-[10px] font-semibold border border-slate-700 uppercase">
                        {{ Auth::user()->role ?? 'Administrator' }}
                    </span>
                </div>
            </div>

            <!-- Sidebar Navigation -->
            <nav class="flex-grow p-4 space-y-6 overflow-y-auto" aria-label="Navigasi Admin">
                <!-- Group 1: UTAMA -->
                <div>
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-widest block mb-2 px-2">UTAMA</span>
                    <div class="space-y-1">
                        <a href="{{ route('admin.dashboard') }}" @click="if(window.innerWidth < 1024) sidebarOpen = false" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.dashboard') ? 'bg-white text-slate-900 shadow-md font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                            <i class="fa-solid fa-chart-pie w-5 text-center text-amber-400" aria-hidden="true"></i>
                            <span>Dashboard Kinerja</span>
                        </a>
                        <a href="{{ route('admin.alumni') }}" @click="if(window.innerWidth < 1024) sidebarOpen = false" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.alumni*') ? 'bg-white text-slate-900 shadow-md font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                            <i class="fa-solid fa-users w-5 text-center text-amber-400" aria-hidden="true"></i>
                            <span>Manajemen Alumni</span>
                        </a>
                        <a href="{{ route('admin.berita') }}" @click="if(window.innerWidth < 1024) sidebarOpen = false" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.berita*') ? 'bg-white text-slate-900 shadow-md font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                            <i class="fa-solid fa-newspaper w-5 text-center text-amber-400" aria-hidden="true"></i>
                            <span>Berita & Kegiatan</span>
                        </a>
                        <a href="{{ route('admin.beasiswa') }}" @click="if(window.innerWidth < 1024) sidebarOpen = false" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.beasiswa*') ? 'bg-white text-slate-900 shadow-md font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                            <i class="fa-solid fa-graduation-cap w-5 text-center text-amber-400" aria-hidden="true"></i>
                            <span>Kelola Beasiswa</span>
                        </a>
                        <a href="{{ route('admin.infografis') }}" @click="if(window.innerWidth < 1024) sidebarOpen = false" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.infografis*') ? 'bg-white text-slate-900 shadow-md font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                            <i class="fa-solid fa-bullhorn w-5 text-center text-amber-400" aria-hidden="true"></i>
                            <span>Kelola Infografis & Popup</span>
                        </a>
                        <a href="{{ route('admin.kategori-berita') }}" @click="if(window.innerWidth < 1024) sidebarOpen = false" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.kategori-berita*') ? 'bg-white text-slate-900 shadow-md font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                            <i class="fa-solid fa-tags w-5 text-center text-amber-400" aria-hidden="true"></i>
                            <span>Kategori Berita</span>
                        </a>
                        <a href="{{ route('admin.galeri') }}" @click="if(window.innerWidth < 1024) sidebarOpen = false" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.galeri*') ? 'bg-white text-slate-900 shadow-md font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                            <i class="fa-solid fa-images w-5 text-center text-amber-400" aria-hidden="true"></i>
                            <span>Galeri Foto</span>
                        </a>
                        <a href="{{ route('admin.pengurus') }}" @click="if(window.innerWidth < 1024) sidebarOpen = false" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.pengurus*') ? 'bg-white text-slate-900 shadow-md font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                            <i class="fa-solid fa-sitemap w-5 text-center text-amber-400" aria-hidden="true"></i>
                            <span>Struktur Pengurus</span>
                        </a>
                    </div>
                </div>

                <!-- Group 2: SISTEM & PUBLIK -->
                <div>
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-widest block mb-2 px-2">SISTEM & PUBLIK</span>
                    <div class="space-y-1">
                        <a href="{{ route('admin.users') }}" @click="if(window.innerWidth < 1024) sidebarOpen = false" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.users*') ? 'bg-white text-slate-900 shadow-md font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                            <i class="fa-solid fa-user-shield w-5 text-center text-sky-400" aria-hidden="true"></i>
                            <span>Manajemen Pengguna</span>
                        </a>
                        <a href="{{ route('home') }}" target="_blank" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-sm font-semibold text-slate-300 hover:bg-slate-800 hover:text-white transition">
                            <i class="fa-solid fa-globe w-5 text-center text-emerald-400" aria-hidden="true"></i>
                            <span>Halaman Website Publik</span>
                        </a>
                    </div>
                </div>
            </nav>

            <!-- Sidebar Footer Logout Button -->
            <div class="p-4 border-t border-slate-800">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center space-x-2 py-2.5 bg-slate-950/80 hover:bg-slate-950 text-white rounded-xl text-xs font-bold transition border border-slate-700">
                        <i class="fa-solid fa-power-off text-rose-400" aria-hidden="true"></i>
                        <span>Keluar Sistem</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- RIGHT CONTENT WRAPPER -->
        <div class="flex-grow flex flex-col min-w-0 w-full">
            <!-- TOPBAR HEADER -->
            <header class="h-16 admin-topbar-slate text-white px-4 sm:px-6 flex items-center justify-between shadow-md sticky top-0 z-30">
                <!-- Left: Hamburger (Mobile) + Page Title -->
                <div class="flex items-center space-x-3">
                    <!-- Mobile Hamburger -->
                    <button @click="sidebarOpen = !sidebarOpen"
                            class="lg:hidden w-9 h-9 rounded-xl bg-slate-800 hover:bg-slate-700 text-white flex items-center justify-center transition text-sm border border-slate-700"
                            :aria-expanded="sidebarOpen.toString()"
                            aria-label="Buka atau tutup menu navigasi admin">
                        <i class="fa-solid fa-bars" x-show="!sidebarOpen" aria-hidden="true"></i>
                        <i class="fa-solid fa-xmark" x-show="sidebarOpen" aria-hidden="true" style="display:none;"></i>
                    </button>
                    <span class="font-heading font-extrabold text-sm sm:text-base tracking-wide flex items-center text-white">
                        <i class="fa-solid fa-gauge-high mr-2 text-amber-400" aria-hidden="true"></i>
                        <span class="hidden sm:inline">Dasbor Panel Internal</span>
                        <span class="sm:hidden">Panel Admin</span>
                    </span>
                </div>

                <!-- Middle: Marquee (desktop only) -->
                <div class="hidden lg:flex items-center bg-slate-950/60 border border-slate-700/80 rounded-full px-4 py-1 text-xs text-white max-w-lg overflow-hidden">
                    <span class="font-bold bg-amber-500 text-slate-900 px-2 py-0.5 rounded-full text-[10px] uppercase mr-2.5 shrink-0">PENGUMUMAN</span>
                    <marquee class="font-medium text-slate-200">Selamat Datang di Panel Admin Portal Resmi IKA SMAN Kajuara / SMAN 8 Bone • Kelola data alumni, berita, galeri, dan kepengurusan dengan cepat & aman.</marquee>
                </div>

                <!-- Right: Tools -->
                <div class="flex items-center space-x-2">
                    <div class="hidden sm:flex items-center space-x-1.5 px-3 py-1 rounded-full bg-slate-800 border border-slate-700 text-xs font-semibold text-slate-200">
                        <i class="fa-solid fa-cloud-sun text-amber-400" aria-hidden="true"></i>
                        <span>28°C - Kajuara</span>
                    </div>
                    <button onclick="window.location.reload();" title="Refresh Page" aria-label="Muat ulang halaman" class="w-8 h-8 rounded-full bg-slate-800 hover:bg-slate-700 text-white flex items-center justify-center transition text-xs border border-slate-700">
                        <i class="fa-solid fa-rotate" aria-hidden="true"></i>
                    </button>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" title="Logout" aria-label="Keluar dari sistem" class="w-8 h-8 rounded-full bg-slate-800 hover:bg-red-600 text-white flex items-center justify-center transition text-xs border border-slate-700">
                            <i class="fa-solid fa-power-off text-rose-400" aria-hidden="true"></i>
                            <span class="sr-only">Keluar</span>
                        </button>
                    </form>
                </div>
            </header>

            <!-- MAIN DASHBOARD CONTENT AREA -->
            <main class="flex-grow p-4 sm:p-6 bg-slate-100 overflow-y-auto">
                @yield('content')
            </main>
        </div>

    </div><!-- end flex wrapper -->

    @stack('scripts')
</body>
</html>
