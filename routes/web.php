<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\BeasiswaController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InfografisController;
use App\Http\Controllers\KtaController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\StrukturController;
use Illuminate\Support\Facades\Route;

// Dynamic XML Sitemap & Robots.txt Routes
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/robots.txt', function () {
    $sitemapUrl = url('/sitemap.xml');
    $content = "User-agent: *\nAllow: /\nDisallow: /admin/\nDisallow: /login\n\nSitemap: {$sitemapUrl}\n";
    return response($content, 200)->header('Content-Type', 'text/plain');
});

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/alumni', [HomeController::class, 'index']);

Route::get('/data-alumni', [AlumniController::class, 'index'])->name('alumni.index');
Route::get('/alumni/data-alumni', [AlumniController::class, 'index']);
Route::post('/alumni/register', [AlumniController::class, 'register'])->name('alumni.register');
Route::get('/data-alumni/api/{id}', [AlumniController::class, 'detail'])->name('alumni.detail');
Route::get('/alumni/data-alumni/api/{id}', [AlumniController::class, 'detail']);

Route::get('/profil', [ProfilController::class, 'index'])->name('profil');
Route::get('/alumni/profil', [ProfilController::class, 'index']);

Route::get('/ad-art', [ProfilController::class, 'adArt'])->name('ad-art');
Route::get('/alumni/ad-art', [ProfilController::class, 'adArt']);

Route::get('/struktur', [StrukturController::class, 'index'])->name('struktur');
Route::get('/alumni/struktur', [StrukturController::class, 'index']);

Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
Route::get('/alumni/berita', [BeritaController::class, 'index']);
Route::get('/berita/{slug}', [BeritaController::class, 'detail'])->name('berita.detail');
Route::get('/alumni/berita/{slug}', [BeritaController::class, 'detail']);

Route::get('/galeri', [GaleriController::class, 'index'])->name('galeri');
Route::get('/alumni/galeri', [GaleriController::class, 'index']);

// KTA Digital Routes
Route::get('/kta', [KtaController::class, 'index'])->name('kta.index');
Route::get('/alumni/kta', [KtaController::class, 'index']);
Route::get('/kta/detail/{id}', [KtaController::class, 'show'])->name('kta.show');
Route::get('/kta/verifikasi/{id}', [KtaController::class, 'verify'])->name('kta.verify');
Route::get('/alumni/kta/verifikasi/{id}', [KtaController::class, 'verify']);

// Beasiswa Routes
Route::get('/beasiswa', [BeasiswaController::class, 'index'])->name('beasiswa.index');
Route::get('/alumni/beasiswa', [BeasiswaController::class, 'index']);

// Infografis Routes
Route::get('/infografis', [InfografisController::class, 'index'])->name('infografis.index');
Route::get('/alumni/infografis', [InfografisController::class, 'index']);

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/alumni/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/alumni/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Panel Routes (Protected by Auth Middleware)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // CRUD Alumni
    Route::get('/alumni', [AdminController::class, 'alumni'])->name('alumni');
    Route::post('/alumni', [AdminController::class, 'storeAlumni'])->name('alumni.store');
    Route::put('/alumni/{id}', [AdminController::class, 'updateAlumni'])->name('alumni.update');
    Route::put('/alumni/{id}/approve', [AdminController::class, 'approveAlumni'])->name('alumni.approve');
    Route::put('/alumni/{id}/reject', [AdminController::class, 'rejectAlumni'])->name('alumni.reject');
    Route::delete('/alumni/bulk-delete', [AdminController::class, 'bulkDeleteAlumni'])->name('alumni.bulkDelete');
    Route::delete('/alumni/{id}', [AdminController::class, 'deleteAlumni'])->name('alumni.delete');

    // Impor & Ekspor Data Alumni Massal
    Route::get('/alumni/download-template', [AdminController::class, 'downloadTemplateAlumni'])->name('alumni.downloadTemplate');
    Route::post('/alumni/preview-import', [AdminController::class, 'previewImportAlumni'])->name('alumni.previewImport');
    Route::post('/alumni/process-import', [AdminController::class, 'processImportAlumni'])->name('alumni.processImport');
    Route::get('/alumni/export-excel', [AdminController::class, 'exportExcelAlumni'])->name('alumni.exportExcel');
    Route::get('/alumni/export-pdf', [AdminController::class, 'exportPdfAlumni'])->name('alumni.exportPdf');

    // CRUD Berita & Kegiatan Public
    Route::get('/berita', [AdminController::class, 'berita'])->name('berita');
    Route::post('/berita', [AdminController::class, 'storeBerita'])->name('berita.store');
    Route::put('/berita/{id}', [AdminController::class, 'updateBerita'])->name('berita.update');
    Route::delete('/berita/{id}', [AdminController::class, 'deleteBerita'])->name('berita.delete');

    // CRUD Galeri Public
    Route::get('/galeri', [AdminController::class, 'galeri'])->name('galeri');
    Route::post('/galeri', [AdminController::class, 'storeGaleri'])->name('galeri.store');
    Route::put('/galeri/{id}', [AdminController::class, 'updateGaleri'])->name('galeri.update');
    Route::delete('/galeri/{id}', [AdminController::class, 'deleteGaleri'])->name('galeri.delete');

    // CRUD Struktur Pengurus Public
    Route::get('/pengurus', [AdminController::class, 'pengurus'])->name('pengurus');
    Route::post('/pengurus', [AdminController::class, 'storePengurus'])->name('pengurus.store');
    Route::put('/pengurus/{id}', [AdminController::class, 'updatePengurus'])->name('pengurus.update');
    Route::delete('/pengurus/{id}', [AdminController::class, 'deletePengurus'])->name('pengurus.delete');

    // CRUD Master Kategori Berita
    Route::get('/kategori-berita', [AdminController::class, 'kategoriBerita'])->name('kategori-berita');
    Route::post('/kategori-berita', [AdminController::class, 'storeKategoriBerita'])->name('kategori-berita.store');
    Route::put('/kategori-berita/{id}', [AdminController::class, 'updateKategoriBerita'])->name('kategori-berita.update');
    Route::delete('/kategori-berita/{id}', [AdminController::class, 'deleteKategoriBerita'])->name('kategori-berita.delete');

    // CRUD Beasiswa
    Route::get('/beasiswa', [AdminController::class, 'beasiswa'])->name('beasiswa');
    Route::post('/beasiswa', [AdminController::class, 'storeBeasiswa'])->name('beasiswa.store');
    Route::put('/beasiswa/{id}', [AdminController::class, 'updateBeasiswa'])->name('beasiswa.update');
    Route::delete('/beasiswa/{id}', [AdminController::class, 'deleteBeasiswa'])->name('beasiswa.delete');

    // CRUD Infografis & Popup Flyer
    Route::get('/infografis', [AdminController::class, 'infografis'])->name('infografis');
    Route::post('/infografis', [AdminController::class, 'storeInfografis'])->name('infografis.store');
    Route::put('/infografis/{id}', [AdminController::class, 'updateInfografis'])->name('infografis.update');
    Route::put('/infografis/{id}/toggle-popup', [AdminController::class, 'togglePopupInfografis'])->name('infografis.togglePopup');
    Route::delete('/infografis/{id}', [AdminController::class, 'deleteInfografis'])->name('infografis.delete');

    // CRUD User Management
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('users.delete');
});
