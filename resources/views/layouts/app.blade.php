<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Dynamic SEO Meta Tags -->
    <title>@yield('title', 'Beranda') - IKA SMAN Kajuara / IKA SMAN 8 Bone</title>
    <meta name="description" content="@yield('meta_description', 'Portal Resmi Ikatan Alumni SMAN Kajuara / IKA SMAN 8 Bone. Wadah silaturahmi, jaringan profesional, berita kegiatan, direktori alumni, dan pengabdian almamater.')">
    <meta name="keywords" content="@yield('meta_keywords', 'IKA SMAN 8 Bone, IKA SMAN Kajuara, Alumni SMAN 8 Bone, Alumni SMAN Kajuara, Portal Alumni Bone, Sekolah SMAN 8 Bone')">
    <meta name="author" content="Ikatan Alumni SMAN Kajuara / IKA SMAN 8 Bone">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- OpenGraph (Facebook, WhatsApp, LinkedIn, Telegram) -->
    <meta property="og:site_name" content="IKA SMAN Kajuara / IKA SMAN 8 Bone">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'Beranda') - IKA SMAN Kajuara / IKA SMAN 8 Bone">
    <meta property="og:description" content="@yield('meta_description', 'Portal Resmi Ikatan Alumni SMAN Kajuara / IKA SMAN 8 Bone. Wadah silaturahmi, jaringan profesional, berita kegiatan, direktori alumni, dan pengabdian almamater.')">
    <meta property="og:image" content="@yield('meta_image', asset('assets/images/meta_image.png'))">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:locale" content="id_ID">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="@yield('title', 'Beranda') - IKA SMAN Kajuara / IKA SMAN 8 Bone">
    <meta name="twitter:description" content="@yield('meta_description', 'Portal Resmi Ikatan Alumni SMAN Kajuara / IKA SMAN 8 Bone. Wadah silaturahmi, jaringan profesional, berita kegiatan, direktori alumni, dan pengabdian almamater.')">
    <meta name="twitter:image" content="@yield('meta_image', asset('assets/images/meta_image.png'))">

    <!-- Favicon -->
    <link rel="icon" type="image/webp" href="{{ asset('assets/images/logo.webp') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/images/logo.webp') }}">

    <!-- Structured Data Schema.org (JSON-LD) -->
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@type": "EducationalOrganization",
        "name": "IKA SMAN Kajuara / IKA SMAN 8 Bone",
        "url": "{{ url('/') }}",
        "logo": "{{ asset('assets/images/logo.webp') }}",
        "sameAs": [
            "https://facebook.com",
            "https://instagram.com",
            "https://youtube.com"
        ],
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "Jl. H. Abd. Hamid, Kajuara",
            "addressLocality": "Kabupaten Bone",
            "addressRegion": "Sulawesi Selatan",
            "postalCode": "92776",
            "addressCountry": "ID"
        }
    }
    </script>
    
    <!-- Google Fonts: Plus Jakarta Sans & Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS (Play CDN for instant ultra-performance) -->
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
                        },
                        accent: {
                            gold: '#d97706',
                            goldLight: '#f59e0b',
                            cyan: '#0284c7',
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
        .glass-header {
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
            box-shadow: 0 4px 20px -5px rgba(0, 0, 0, 0.03);
        }
        .glass-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.04), 0 8px 10px -6px rgba(0, 0, 0, 0.02);
        }
        .glass-card:hover {
            border-color: rgba(217, 119, 6, 0.4);
            box-shadow: 0 20px 30px -10px rgba(0, 0, 0, 0.08);
        }
        .gradient-text-light {
            background: linear-gradient(135deg, #0f172a 0%, #334155 50%, #d97706 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased min-h-screen flex flex-col selection:bg-slate-900 selection:text-white">

    <!-- Header Navigation -->
    @include('partials.header')

    <!-- Main Content Area -->
    <main class="flex-grow pt-24">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('partials.footer')

    @stack('scripts')
</body>
</html>
