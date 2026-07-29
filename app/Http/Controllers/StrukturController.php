<?php

namespace App\Http\Controllers;

use App\Models\Bidang;
use App\Models\Pengurus;
use Illuminate\Http\Request;

class StrukturController extends Controller
{
    public function index()
    {
        $pengurusInti = Pengurus::where('is_inti', 1)->orderBy('urutan', 'asc')->get();
        $semuaPengurus = Pengurus::with('bidang')->orderBy('is_inti', 'desc')->orderBy('urutan', 'asc')->get();
        $bidangList = Bidang::with(['pengurus' => function ($q) {
            $q->orderBy('urutan', 'asc');
        }])->orderBy('urutan', 'asc')->get();

        return view('pages.struktur', compact('pengurusInti', 'semuaPengurus', 'bidangList'));
    }
}
