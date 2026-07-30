<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\Berita;
use App\Models\Galeri;
use App\Models\Pengurus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // Counter Statistics
        $totalAlumni = Alumni::count();
        $totalAngkatan = Alumni::distinct('angkatan')->count('angkatan');
        $totalBerita = Berita::where('status', 'published')->count();
        $totalPengurus = Pengurus::where('is_inti', 1)->count();

        // 📊 GRAFIK 1: Sebaran Kategori Profesi Alumni (Donut Chart)
        $allAlumniProfesi = Alumni::where(function($q) {
            $q->whereNotNull('profesi')->orWhereNotNull('kategori_profesi');
        })->get();
        $profesiGrouped = [];

        foreach ($allAlumniProfesi as $alm) {
            $cat = Alumni::getKategoriProfesi($alm->profesi, $alm->kategori_profesi);
            if (!isset($profesiGrouped[$cat])) {
                $profesiGrouped[$cat] = 0;
            }
            $profesiGrouped[$cat]++;
        }

        arsort($profesiGrouped);

        $profesiLabels = array_keys($profesiGrouped);
        $profesiCounts = array_values($profesiGrouped);

        // 📊 GRAFIK 2: Sebaran Alumni per Dekade Angkatan (Column/Bar Chart)
        $dekadeData = [
            '1990 - 1999' => Alumni::whereBetween('angkatan', [1990, 1999])->count(),
            '2000 - 2009' => Alumni::whereBetween('angkatan', [2000, 2009])->count(),
            '2010 - 2019' => Alumni::whereBetween('angkatan', [2010, 2019])->count(),
            '2020 - 2026' => Alumni::whereBetween('angkatan', [2020, 2026])->count(),
        ];
        $dekadeLabels = array_keys($dekadeData);
        $dekadeCounts = array_values($dekadeData);

        // 📊 GRAFIK 3: Trend Keaktifan & Pertumbuhan Alumni 6 Bulan (Spline Area Chart Realtime)
        $trendMonths = [];
        $trendRegistrasi = [];
        $trendKegiatan = [];

        for ($i = 5; $i >= 0; $i--) {
            $monthDate = now()->subMonths($i);
            $monthName = $monthDate->translatedFormat('M');
            $year = $monthDate->year;
            $month = $monthDate->month;

            // Total akumulasi registrasi alumni hingga akhir bulan tersebut (Grafik Pertumbuhan)
            $regCount = Alumni::where('created_at', '<=', $monthDate->copy()->endOfMonth())->count();
            
            // Total kegiatan / berita publik yang terbit pada bulan tersebut
            $kegiatanCount = Berita::where('status', 'published')
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->count();

            $trendMonths[] = $monthName;
            $trendRegistrasi[] = $regCount;
            $trendKegiatan[] = $kegiatanCount;
        }

        // Highlight Berita Terbaru
        $beritaHighlights = Berita::where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        // Highlight Alumni Berprestasi / Inspiratif (Prioritaskan is_berprestasi = 1)
        $alumniHighlights = Alumni::where('is_berprestasi', 1)->orderBy('updated_at', 'desc')->take(4)->get();
        if ($alumniHighlights->count() < 4) {
            $needed = 4 - $alumniHighlights->count();
            $alreadyIds = $alumniHighlights->pluck('id')->toArray();
            $extra = Alumni::whereNotIn('id', $alreadyIds)->orderBy('angkatan', 'desc')->take($needed)->get();
            $alumniHighlights = $alumniHighlights->concat($extra);
        }

        // Recent Galeri Preview
        $galeriPreviews = Galeri::orderBy('created_at', 'desc')->take(4)->get();

        return view('pages.home', compact(
            'totalAlumni',
            'totalAngkatan',
            'totalBerita',
            'totalPengurus',
            'profesiLabels',
            'profesiCounts',
            'dekadeLabels',
            'dekadeCounts',
            'trendMonths',
            'trendRegistrasi',
            'trendKegiatan',
            'beritaHighlights',
            'alumniHighlights',
            'galeriPreviews'
        ));
    }
}
