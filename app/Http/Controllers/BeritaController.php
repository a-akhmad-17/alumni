<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    public function index(Request $request)
    {
        $query = Berita::where('status', 'published');

        if ($request->filled('q')) {
            $query->where('judul', 'like', "%{$request->q}%")
                  ->orWhere('isi', 'like', "%{$request->q}%");
        }

        if ($request->filled('kategori') && $request->kategori !== 'semua') {
            $query->where('kategori', $request->kategori);
        }

        $beritaList = $query->orderBy('created_at', 'desc')->paginate(6)->withQueryString();
        $recentPosts = Berita::where('status', 'published')->orderBy('created_at', 'desc')->take(4)->get();
        $currentKategori = $request->get('kategori', 'semua');

        return view('pages.berita', compact('beritaList', 'recentPosts', 'currentKategori'));
    }

    public function detail($slug)
    {
        $berita = Berita::where('slug', $slug)->firstOrFail();
        $recentPosts = Berita::where('status', 'published')->where('id', '!=', $berita->id)->orderBy('created_at', 'desc')->take(4)->get();

        return view('pages.berita_detail', compact('berita', 'recentPosts'));
    }
}
