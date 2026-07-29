<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;

class SitemapController extends Controller
{
    public function index()
    {
        $beritaList = Berita::where('status', 'published')->orderBy('updated_at', 'desc')->get();
        $latestBerita = $beritaList->first();
        $latestUpdated = $latestBerita ? $latestBerita->updated_at : now();

        return response()->view('sitemap', [
            'beritaList' => $beritaList,
            'latestUpdated' => $latestUpdated,
        ])->header('Content-Type', 'text/xml; charset=UTF-8');
    }
}
