<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\Berita;
use App\Models\Galeri;
use App\Models\Infografis;
use App\Models\Pengurus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Counter Statistics
        $totalAlumni = Alumni::count();
        $totalAngkatan = Alumni::distinct('angkatan')->count('angkatan');
        $totalBerita = Berita::where('status', 'published')->count();
        $totalPengurus = Pengurus::where('is_inti', 1)->count();

        // 📅 List Available Registration Years for Filter
        $availableYears = Alumni::selectRaw('YEAR(created_at) as yr')
            ->distinct()
            ->orderBy('yr', 'desc')
            ->pluck('yr')
            ->filter()
            ->values()
            ->toArray();

        $currentYr = (int) date('Y');
        if (!in_array($currentYr, $availableYears)) {
            array_unshift($availableYears, $currentYr);
        }

        $chartYear = $request->query('chart_year', 'semua');

        // 📊 GRAFIK 1: Sebaran Kategori Profesi Alumni (Donut Chart)
        $profesiQuery = Alumni::where(function($q) {
            $q->whereNotNull('profesi')->orWhereNotNull('kategori_profesi');
        });

        if ($chartYear !== 'semua') {
            $profesiQuery->whereYear('created_at', $chartYear);
        }

        $allAlumniProfesi = $profesiQuery->get();
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

        if (empty($profesiLabels)) {
            $profesiLabels = ['Belum ada data'];
            $profesiCounts = [0];
        }

        // 📊 GRAFIK 2: Sebaran Alumni per Dekade Angkatan (Column/Bar Chart)
        $dekadeQuery = function($min, $max) use ($chartYear) {
            $q = Alumni::whereBetween('angkatan', [$min, $max]);
            if ($chartYear !== 'semua') {
                $q->whereYear('created_at', $chartYear);
            }
            return $q->count();
        };

        $dekadeData = [
            '1988 - 1999' => $dekadeQuery(1988, 1999),
            '2000 - 2009' => $dekadeQuery(2000, 2009),
            '2010 - 2019' => $dekadeQuery(2010, 2019),
            '2020 - 2026' => $dekadeQuery(2020, 2026),
        ];
        $dekadeLabels = array_keys($dekadeData);
        $dekadeCounts = array_values($dekadeData);

        // 📊 GRAFIK 3: Trend Keaktifan & Pertumbuhan Alumni (Spline Area Chart Realtime)
        $trendMonths = [];
        $trendRegistrasi = [];
        $trendKegiatan = [];

        if ($chartYear !== 'semua') {
            // Trend 12 Bulan untuk Tahun Terpilih
            $indonesianMonths = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
            for ($m = 1; $m <= 12; $m++) {
                $monthDate = \Carbon\Carbon::createFromDate((int) $chartYear, $m, 1);
                
                $regCount = Alumni::where('created_at', '<=', $monthDate->copy()->endOfMonth())->count();
                $kegiatanCount = Berita::where('status', 'published')
                    ->whereYear('created_at', $chartYear)
                    ->whereMonth('created_at', $m)
                    ->count();

                $trendMonths[] = $indonesianMonths[$m - 1];
                $trendRegistrasi[] = $regCount;
                $trendKegiatan[] = $kegiatanCount;
            }
        } else {
            // Trend 6 Bulan Terakhir
            for ($i = 5; $i >= 0; $i--) {
                $monthDate = now()->subMonths($i);
                $monthName = $monthDate->translatedFormat('M');
                $year = $monthDate->year;
                $month = $monthDate->month;

                $regCount = Alumni::where('created_at', '<=', $monthDate->copy()->endOfMonth())->count();
                $kegiatanCount = Berita::where('status', 'published')
                    ->whereYear('created_at', $year)
                    ->whereMonth('created_at', $month)
                    ->count();

                $trendMonths[] = $monthName;
                $trendRegistrasi[] = $regCount;
                $trendKegiatan[] = $kegiatanCount;
            }
        }

        // Highlight Berita Terbaru
        $beritaHighlights = Berita::where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        // Recent Galeri Preview
        $galeriPreviews = Galeri::orderBy('created_at', 'desc')->take(4)->get();

        // 📢 Auto Popup Announcement Flyers (Max 3 Active Popup Flyers)
        $popupFlyers = Infografis::where('is_popup', 1)
            ->where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

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
            'galeriPreviews',
            'availableYears',
            'chartYear',
            'popupFlyers'
        ));
    }
}
