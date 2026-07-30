<?php

namespace App\Http\Controllers;

use App\Models\Beasiswa;
use Illuminate\Http\Request;

class BeasiswaController extends Controller
{
    /**
     * Halaman Publik Informasi Beasiswa (Wide Banner Layout)
     */
    public function index(Request $request)
    {
        $query = Beasiswa::where('status', 'published');

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('informasi', 'like', "%{$search}%");
            });
        }

        $beasiswaList = $query->orderBy('created_at', 'desc')
                             ->paginate(6)
                             ->withQueryString();

        return view('pages.beasiswa', compact('beasiswaList'));
    }
}
