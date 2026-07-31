<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use Illuminate\Http\Request;

class KtaController extends Controller
{
    /**
     * Halaman Utama KTA Digital & Pencarian Kartu Alumni
     */
    public function index(Request $request)
    {
        $query = Alumni::where('status', 'approved');

        // Filter Angkatan
        if ($request->filled('angkatan')) {
            $query->where('angkatan', $request->angkatan);
        }

        // Filter Pencarian Nama / Profesi / Domisili
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('profesi', 'like', "%{$search}%")
                  ->orWhere('domisili', 'like', "%{$search}%");
            });
        }

        $alumniList = $query->orderBy('angkatan', 'desc')
                           ->orderBy('nama', 'asc')
                           ->paginate(12)
                           ->withQueryString();

        // Ambil alumni terpilih untuk preview KTA (jika ada param id / dipilihi)
        $selectedAlumni = null;
        if ($request->filled('id')) {
            $selectedAlumni = Alumni::where('status', 'approved')->find($request->id);
        }

        // Jika tidak ada ID khusus yang dipilihi tetapi hasil pencarian ada, pilih yang pertama sebagai default preview
        if (!$selectedAlumni && $alumniList->count() > 0) {
            $selectedAlumni = $alumniList->first();
        }

        // List Angkatan untuk Dropdown Filter
        $angkatanList = Alumni::where('status', 'approved')
            ->select('angkatan')
            ->distinct()
            ->orderBy('angkatan', 'desc')
            ->pluck('angkatan');

        return view('pages.kta', compact('alumniList', 'selectedAlumni', 'angkatanList'));
    }

    /**
     * API / View Detail KTA Spesifik Alumni
     */
    public function show($id)
    {
        $alumni = Alumni::where('status', 'approved')->findOrFail($id);
        
        // Format Nomor KTA Resmi
        $ktaNumber = $this->generateKtaNumber($alumni);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $alumni->id,
                'nama' => $alumni->nama,
                'jenis_kelamin' => $alumni->jenis_kelamin,
                'angkatan' => $alumni->angkatan,
                'profesi' => !empty($alumni->profesi) ? $alumni->profesi : (!empty($alumni->kategori_profesi) ? $alumni->kategori_profesi : 'Alumni SMAN 8 Bone'),
                'domisili' => $alumni->domisili ?? 'Indonesia',
                'foto' => $alumni->foto ? (str_starts_with($alumni->foto, 'http') ? $alumni->foto : asset($alumni->foto)) : null,
                'no_kta' => $ktaNumber,
                'verify_url' => route('kta.verify', $alumni->id),
                'status' => 'Terverifikasi IKA'
            ]
        ]);
    }

    /**
     * Halaman Publik Verifikasi Keaslian KTA (Hasil Scan QR Code)
     */
    public function verify($id)
    {
        $alumni = Alumni::where('status', 'approved')->find($id);

        if (!$alumni) {
            return view('pages.kta_verify', [
                'isValid' => false,
                'alumni' => null,
                'ktaNumber' => null,
                'message' => 'Data KTA tidak ditemukan atau belum disetujui oleh Admin IKA.'
            ]);
        }

        $ktaNumber = $this->generateKtaNumber($alumni);

        return view('pages.kta_verify', [
            'isValid' => true,
            'alumni' => $alumni,
            'ktaNumber' => $ktaNumber,
            'message' => 'Kartu Tanda Anggota (KTA) Resmi & Terverifikasi Aktif.'
        ]);
    }

    /**
     * Helper Generate Nomor KTA Unik & Standardized
     * Format: KTA-IKA.[TahunAngkatan].[KodeHash4Digit]
     */
    private function generateKtaNumber($alumni)
    {
        if (!empty($alumni->no_kta)) {
            return $alumni->no_kta;
        }

        $hash = strtoupper(substr(md5($alumni->id . $alumni->created_at), 0, 5));
        return "KTA-IKA.{$alumni->angkatan}.{$hash}";
    }
}
