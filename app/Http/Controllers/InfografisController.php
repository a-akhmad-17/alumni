<?php

namespace App\Http\Controllers;

use App\Models\Infografis;
use Illuminate\Http\Request;

class InfografisController extends Controller
{
    /**
     * Halaman Publik Galeri Infografis & Flyer Announcement
     */
    public function index(Request $request)
    {
        $query = Infografis::where('status', 'published');

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        $infografisList = $query->orderBy('created_at', 'desc')
                               ->paginate(12)
                               ->withQueryString();

        return view('pages.infografis', compact('infografisList'));
    }
}
