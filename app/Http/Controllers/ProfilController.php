<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function index()
    {
        return view('pages.profil');
    }

    public function adArt()
    {
        return view('pages.ad_art');
    }
}
