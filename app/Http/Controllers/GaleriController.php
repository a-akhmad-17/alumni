<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use Illuminate\Http\Request;

class GaleriController extends Controller
{
    public function index(Request $request)
    {
        $query = Galeri::query();

        if ($request->filled('q')) {
            $query->where(function($q) use ($request) {
                $q->where('judul', 'like', "%{$request->q}%")
                  ->orWhere('deskripsi', 'like', "%{$request->q}%");
            });
        }

        if ($request->filled('kategori') && $request->kategori != 'Semua' && $request->kategori != 'semua') {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('tipe') && $request->tipe != 'semua') {
            $query->where('tipe', $request->tipe);
        }

        $galeriList = $query->orderBy('created_at', 'desc')->get();
        $kategoriList = Galeri::distinct()->pluck('kategori');

        // Group photos by activity title for multi-photo album view
        $kegiatanGrouped = $galeriList->groupBy('judul');

        return view('pages.galeri', compact('galeriList', 'kategoriList', 'kegiatanGrouped'));
    }
}
