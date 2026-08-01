<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlumniController extends Controller
{
    public function index(Request $request)
    {
        $query = Alumni::where('status', 'approved');

        // Search Filter by Nama / Email / No HP / Profesi
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('profesi', 'like', "%{$search}%")
                  ->orWhere('domisili', 'like', "%{$search}%");
            });
        }

        // Filter by Angkatan
        if ($request->filled('angkatan')) {
            $query->where('angkatan', $request->angkatan);
        }

        // Filter by Domisili
        if ($request->filled('domisili')) {
            $query->where('domisili', 'like', "%{$request->domisili}%");
        }

        $alumniList = $query->orderBy('angkatan', 'desc')->orderBy('nama', 'asc')->paginate(9)->withQueryString();

        // Dropdown List Angkatan & Domisili (hanya data approved)
        $angkatanList = Alumni::where('status', 'approved')->distinct()->orderBy('angkatan', 'desc')->pluck('angkatan');
        $domisiliList = Alumni::where('status', 'approved')->distinct()->whereNotNull('domisili')->orderBy('domisili', 'asc')->pluck('domisili');

        // 📊 GRAFIK DETAILED UNTUK HALAMAN ALUMNI (Dapat difilter dinamis):
        // 1. Top Domisili Kota Alumni
        $domisiliQuery = Alumni::where('status', 'approved');
        if ($request->filled('angkatan')) $domisiliQuery->where('angkatan', $request->angkatan);
        if ($request->filled('gender')) $domisiliQuery->where('jenis_kelamin', $request->gender);

        $domisiliChartData = $domisiliQuery->select('domisili', DB::raw('count(*) as total'))
            ->whereNotNull('domisili')
            ->groupBy('domisili')
            ->orderBy('total', 'desc')
            ->take(5)
            ->get();
        $domisiliChartLabels = $domisiliChartData->pluck('domisili')->toArray();
        $domisiliChartCounts = $domisiliChartData->pluck('total')->toArray();

        // 2. Sebaran Angkatan Detail
        $angkatanQuery = Alumni::where('status', 'approved');
        if ($request->filled('domisili')) $angkatanQuery->where('domisili', 'like', "%{$request->domisili}%");
        if ($request->filled('gender')) $angkatanQuery->where('jenis_kelamin', $request->gender);

        $angkatanChartData = $angkatanQuery->select('angkatan', DB::raw('count(*) as total'))
            ->groupBy('angkatan')
            ->orderBy('angkatan', 'asc')
            ->take(8)
            ->get();
        $angkatanChartLabels = $angkatanChartData->pluck('angkatan')->map(fn($item) => 'Thn ' . $item)->toArray();
        $angkatanChartCounts = $angkatanChartData->pluck('total')->toArray();

        // 3. Grafik Rasio Jenis Kelamin
        $genderQuery = Alumni::where('status', 'approved');
        if ($request->filled('angkatan')) $genderQuery->where('angkatan', $request->angkatan);
        if ($request->filled('domisili')) $genderQuery->where('domisili', 'like', "%{$request->domisili}%");

        $genderChartData = $genderQuery->select('jenis_kelamin', DB::raw('count(*) as total'))
            ->whereNotNull('jenis_kelamin')
            ->groupBy('jenis_kelamin')
            ->get();
        $genderChartLabels = $genderChartData->pluck('jenis_kelamin')->toArray();
        $genderChartCounts = $genderChartData->pluck('total')->toArray();

        return view('pages.alumni', compact(
            'alumniList',
            'angkatanList',
            'domisiliList',
            'domisiliChartLabels',
            'domisiliChartCounts',
            'angkatanChartLabels',
            'angkatanChartCounts',
            'genderChartLabels',
            'genderChartCounts'
        ));
    }

    private function saveBase64Webp($base64Data, $folder)
    {
        $destinationPath = public_path('uploads/' . $folder);
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        if (preg_match('/^data:image\/(\w+);base64,/', $base64Data)) {
            $data = substr($base64Data, strpos($base64Data, ',') + 1);
            $imageBase64 = base64_decode($data);
            if ($imageBase64 === false) return null;
        } else {
            return null;
        }

        $filename = time() . '_' . \Illuminate\Support\Str::random(8) . '.webp';
        $targetFile = $destinationPath . '/' . $filename;

        $image = @imagecreatefromstring($imageBase64);
        if ($image) {
            imagewebp($image, $targetFile, 85);
            imagedestroy($image);
        } else {
            file_put_contents($targetFile, $imageBase64);
        }

        @chmod($targetFile, 0644);

        return 'uploads/' . $folder . '/' . $filename;
    }

    private function uploadAndConvertToWebp($file, $folder)
    {
        $destinationPath = public_path('uploads/' . $folder);
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
            @chmod($destinationPath, 0755);
        }

        $filename = time() . '_' . \Illuminate\Support\Str::random(8) . '.webp';
        $targetFile = $destinationPath . '/' . $filename;

        $imageInfo = @getimagesize($file->getRealPath());
        $mime = $imageInfo['mime'] ?? '';

        $image = null;
        switch ($mime) {
            case 'image/jpeg':
            case 'image/jpg':
                $image = @imagecreatefromjpeg($file->getRealPath());
                break;
            case 'image/png':
                $image = @imagecreatefrompng($file->getRealPath());
                if ($image) {
                    imagepalettetotruecolor($image);
                    imagealphablending($image, true);
                    imagesavealpha($image, true);
                }
                break;
            case 'image/webp':
                $image = @imagecreatefromwebp($file->getRealPath());
                break;
        }

        if ($image) {
            imagewebp($image, $targetFile, 80);
            imagedestroy($image);
        } else {
            $file->move($destinationPath, $filename);
        }

        @chmod($targetFile, 0644);

        return 'uploads/' . $folder . '/' . $filename;
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:150',
            'jenis_kelamin' => 'required|string|max:20',
            'angkatan' => 'required|integer|min:1988|max:2026',
            'profesi' => 'nullable|string|max:150',
            'kategori_profesi' => 'nullable|string|max:100',
            'domisili' => 'nullable|string|max:150',
            'no_hp' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:100',
            'foto' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120',
            'foto_cropped' => 'nullable|string',
        ]);

        $fotoUrl = null;
        if ($request->filled('foto_cropped')) {
            $fotoUrl = $this->saveBase64Webp($request->foto_cropped, 'alumni');
        } elseif ($request->hasFile('foto')) {
            $fotoUrl = $this->uploadAndConvertToWebp($request->file('foto'), 'alumni');
        }

        $alumni = Alumni::create([
            'id' => (string) \Illuminate\Support\Str::uuid(),
            'nama' => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'angkatan' => $request->angkatan,
            'profesi' => $request->profesi,
            'kategori_profesi' => $request->kategori_profesi ?? Alumni::getKategoriProfesi($request->profesi),
            'domisili' => $request->domisili,
            'no_hp' => $request->no_hp,
            'email' => $request->email,
            'foto' => $fotoUrl,
            'status' => 'pending',
        ]);

        // Auto Notification to Telegram Group/Admin
        $msg = "<b>🔔 PENDAFTARAN ALUMNI BARU (PENDING)</b>\n\n";
        $msg .= "👤 <b>Nama:</b> {$alumni->nama}\n";
        $msg .= "🎓 <b>Angkatan:</b> {$alumni->angkatan}\n";
        $msg .= "💼 <b>Profesi:</b> " . ($alumni->profesi ?? '-') . "\n";
        $msg .= "📍 <b>Domisili:</b> " . ($alumni->domisili ?? '-') . "\n";
        $msg .= "📲 <b>No HP:</b> " . ($alumni->no_hp ?? '-') . "\n";
        $msg .= "📧 <b>Email:</b> " . ($alumni->email ?? '-') . "\n";
        $msg .= "🖼️ <b>Foto:</b> " . ($alumni->foto ? 'Sudah Diunggah ✅' : 'Belum Ada ❌') . "\n\n";
        $msg .= "<i>Silakan buka Admin Panel untuk Verifikasi & Approval.</i>";

        \App\Services\NotificationService::sendTelegramNotification($msg);

        return back()->with('success', 'Pendaftaran alumni berhasil diajukan! Data akan diverifikasi terlebih dahulu oleh Admin/Koordinator Angkatan sebelum ditampilkan.');
    }

    public function detail($id)
    {
        $alumni = Alumni::findOrFail($id);
        return response()->json($alumni);
    }
}
