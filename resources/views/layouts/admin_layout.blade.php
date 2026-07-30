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
                    colors: {
                        grey: {
                            50: '#f8fafc',
                            100: '#f1f5f9',
                            200: '#e2e8f0',
                            300: '#cbd5e1',
                            400: '#94a3b8',
                            500: '#64748b',
                            600: '#475569',
                            700: '#334155',
                            800: '#1e293b',
                            900: '#0f172a',
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- FontAwesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <!-- Alpine.js Interactivity -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- ApexCharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <style>
        .admin-sidebar-slate {
            background: linear-gradient(180deg, #0f172a 0%, #1e293b 60%, #0f172a 100%);
        }
        .admin-topbar-slate {
            background: linear-gradient(90deg, #0f172a 0%, #1e293b 100%);
            border-bottom: 1px solid rgba(226, 232, 240, 0.15);
        }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 font-sans antialiased min-h-screen flex">

    <!-- LEFT SIDEBAR (Executive Deep Slate Grey) -->
    <aside class="w-64 admin-sidebar-slate text-white flex flex-col shrink-0 min-h-screen shadow-2xl z-30">
        <!-- Logo & Header -->
        <div class="p-5 border-b border-slate-800 flex items-center space-x-3">
            <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="h-10 w-auto bg-white/10 p-1 rounded-lg">
            <div>
                <span class="font-heading font-extrabold text-xs uppercase tracking-wider block text-white">IKA SMAN KAJUARA</span>
                <span class="text-[10px] text-amber-400 block uppercase font-semibold">SMAN 8 BONE</span>
            </div>
        </div>

        <!-- User Profile Card -->
        <div class="p-4 border-b border-slate-800 flex items-center space-x-3 bg-slate-950/50">
            <div class="w-10 h-10 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center font-heading font-bold text-amber-400 text-lg">
                {{ substr(Auth::user()->full_name ?? 'Admin', 0, 1) }}
            </div>
            <div>
                <span class="font-bold text-sm text-white block truncate max-w-[140px]">{{ Auth::user()->full_name ?? 'Admin' }}</span>
                <span class="px-2 py-0.5 rounded-full bg-slate-800 text-slate-300 text-[10px] font-semibold border border-slate-700 uppercase">
                    {{ Auth::user()->role ?? 'Administrator' }}
                </span>
            </div>
        </div>

        <!-- Sidebar Navigation -->
        <nav class="flex-grow p-4 space-y-6 overflow-y-auto">
            <!-- Group 1: UTAMA -->
            <div>
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-widest block mb-2 px-2">UTAMA</span>
                <div class="space-y-1">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.dashboard') ? 'bg-white text-slate-900 shadow-md font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-chart-pie w-5 text-center text-amber-400"></i>
                        <span>Dashboard Kinerja</span>
                    </a>
                    <a href="{{ route('admin.alumni') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.alumni*') ? 'bg-white text-slate-900 shadow-md font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-users w-5 text-center text-amber-400"></i>
                        <span>Manajemen Alumni</span>
                    </a>
                    <a href="{{ route('admin.berita') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.berita*') ? 'bg-white text-slate-900 shadow-md font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-newspaper w-5 text-center text-amber-400"></i>
                        <span>Berita & Kegiatan</span>
                    </a>
                    <a href="{{ route('admin.beasiswa') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.beasiswa*') ? 'bg-white text-slate-900 shadow-md font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-graduation-cap w-5 text-center text-amber-400"></i>
                        <span>Kelola Beasiswa</span>
                    </a>
                    <a href="{{ route('admin.infografis') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.infografis*') ? 'bg-white text-slate-900 shadow-md font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-bullhorn w-5 text-center text-amber-400"></i>
                        <span>Kelola Infografis & Popup</span>
                    </a>
                    <a href="{{ route('admin.kategori-berita') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.kategori-berita*') ? 'bg-white text-slate-900 shadow-md font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-tags w-5 text-center text-amber-400"></i>
                        <span>Kategori Berita</span>
                    </a>
                    <a href="{{ route('admin.galeri') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.galeri*') ? 'bg-white text-slate-900 shadow-md font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-images w-5 text-center text-amber-400"></i>
                        <span>Galeri Foto</span>
                    </a>
                    <a href="{{ route('admin.pengurus') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.pengurus*') ? 'bg-white text-slate-900 shadow-md font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-sitemap w-5 text-center text-amber-400"></i>
                        <span>Struktur Pengurus</span>
                    </a>
                </div>
            </div>

            <!-- Group 2: SISTEM & PUBLIK -->
            <div>
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-widest block mb-2 px-2">SISTEM & PUBLIK</span>
                <div class="space-y-1">
                    <a href="{{ route('admin.users') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.users*') ? 'bg-white text-slate-900 shadow-md font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-user-shield w-5 text-center text-sky-400"></i>
                        <span>Manajemen Pengguna</span>
                    </a>
                    <a href="{{ route('home') }}" target="_blank" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-sm font-semibold text-slate-300 hover:bg-slate-800 hover:text-white transition">
                        <i class="fa-solid fa-globe w-5 text-center text-emerald-400"></i>
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
                    <i class="fa-solid fa-power-off text-rose-400"></i>
                    <span>Keluar Sistem</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- RIGHT CONTENT WRAPPER -->
    <div class="flex-grow flex flex-col min-w-0">
        <!-- TOPBAR HEADER -->
        <header class="h-16 admin-topbar-slate text-white px-6 flex items-center justify-between shadow-md">
            <!-- Left: Page Title -->
            <div class="flex items-center space-x-4">
                <span class="font-heading font-extrabold text-base tracking-wide flex items-center text-white">
                    <i class="fa-solid fa-gauge-high mr-2 text-amber-400"></i>Dasbor Panel Internal
                </span>
            </div>

            <!-- Middle: Marquee Announcement Banner -->
            <div class="hidden lg:flex items-center bg-slate-950/60 border border-slate-700/80 rounded-full px-4 py-1 text-xs text-white max-w-lg overflow-hidden">
                <span class="font-bold bg-amber-500 text-slate-900 px-2 py-0.5 rounded-full text-[10px] uppercase mr-2.5 shrink-0">PENGUMUMAN</span>
                <marquee class="font-medium text-slate-200">Selamat Datang di Panel Admin Portal Resmi IKA SMAN Kajuara / SMAN 8 Bone • Kelola data alumni, berita, galeri, dan kepengurusan dengan cepat & aman.</marquee>
            </div>

            <!-- Right: Weather / Action Tools -->
            <div class="flex items-center space-x-3">
                <div class="hidden sm:flex items-center space-x-1.5 px-3 py-1 rounded-full bg-slate-800 border border-slate-700 text-xs font-semibold text-slate-200">
                    <i class="fa-solid fa-cloud-sun text-amber-400"></i>
                    <span>28°C - Kajuara, Bone</span>
                </div>
                <button onclick="window.location.reload();" title="Refresh Page" class="w-8 h-8 rounded-full bg-slate-800 hover:bg-slate-700 text-white flex items-center justify-center transition text-xs border border-slate-700">
                    <i class="fa-solid fa-rotate"></i>
                </button>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" title="Logout" class="w-8 h-8 rounded-full bg-slate-800 hover:bg-red-600 text-white flex items-center justify-center transition text-xs border border-slate-700">
                        <i class="fa-solid fa-power-off text-rose-400"></i>
                    </button>
                </form>
            </div>
        </header>

        <!-- MAIN DASHBOARD CONTENT AREA -->
        <main class="flex-grow p-6 bg-slate-100 overflow-y-auto">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
