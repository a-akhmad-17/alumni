<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\Beasiswa;
use App\Models\Berita;
use App\Models\Bidang;
use App\Models\Galeri;
use App\Models\Infografis;
use App\Models\KategoriBerita;
use App\Models\Pengurus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalAlumni = Alumni::count();
        $totalBerita = Berita::count();
        $totalGaleri = Galeri::count();
        $totalPengurus = Pengurus::count();
        $totalBeasiswa = Beasiswa::count();

        $recentAlumni = Alumni::orderBy('created_at', 'desc')->take(5)->get();
        $recentBerita = Berita::orderBy('created_at', 'desc')->take(5)->get();

        return view('admin.dashboard', compact(
            'totalAlumni',
            'totalBerita',
            'totalGaleri',
            'totalPengurus',
            'totalBeasiswa',
            'recentAlumni',
            'recentBerita'
        ));
    }

    // ==================== HELPER UPLOAD & WEBP CONVERTER ====================
    private function uploadAndConvertToWebp($file, $folder)
    {
        $destinationPath = public_path('uploads/' . $folder);
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        $filename = time() . '_' . Str::random(8) . '.webp';
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

        return 'uploads/' . $folder . '/' . $filename;
    }

    // ==================== KELOLA ALUMNI ====================
    public function alumni(Request $request)
    {
        $query = Alumni::query();

        // 1. Search Query (Nama, Profesi, Domisili, No HP, Email)
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('profesi', 'like', "%{$search}%")
                  ->orWhere('domisili', 'like', "%{$search}%")
                  ->orWhere('no_hp', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // 2. Status Verifikasi (pending, approved, rejected)
        if ($request->filled('status') && $request->status !== 'semua') {
            $query->where('status', $request->status);
        }

        // 3. Filter Angkatan
        if ($request->filled('angkatan')) {
            $query->where('angkatan', $request->angkatan);
        }

        // 4. Filter Domisili
        if ($request->filled('domisili')) {
            $query->where('domisili', 'like', "%{$request->domisili}%");
        }

        // 5. Filter Gender
        if ($request->filled('gender')) {
            $query->where('jenis_kelamin', $request->gender);
        }

        $alumniList = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        $pendingCount = Alumni::where('status', 'pending')->count();
        $angkatanList = Alumni::distinct()->orderBy('angkatan', 'desc')->pluck('angkatan');
        $domisiliList = Alumni::distinct()->whereNotNull('domisili')->where('domisili', '!=', '')->orderBy('domisili', 'asc')->pluck('domisili');

        return view('admin.alumni_index', compact('alumniList', 'pendingCount', 'angkatanList', 'domisiliList'));
    }

    public function storeAlumni(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:150',
            'jenis_kelamin' => 'nullable|string|max:20',
            'angkatan' => 'required|integer',
            'profesi' => 'nullable|string|max:150',
            'domisili' => 'nullable|string|max:150',
            'no_hp' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:100',
            'foto' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120',
        ]);

        $fotoUrl = null;
        if ($request->hasFile('foto')) {
            $fotoUrl = $this->uploadAndConvertToWebp($request->file('foto'), 'alumni');
        }

        Alumni::create([
            'id' => (string) Str::uuid(),
            'nama' => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin ?? 'Laki-laki',
            'angkatan' => $request->angkatan,
            'profesi' => $request->profesi,
            'kategori_profesi' => $request->kategori_profesi ?? Alumni::getKategoriProfesi($request->profesi),
            'domisili' => $request->domisili,
            'no_hp' => $request->no_hp,
            'email' => $request->email,
            'foto' => $fotoUrl,
            'status' => 'approved',
        ]);

        return back()->with('success', 'Data alumni berhasil ditambahkan!');
    }

    public function updateAlumni(Request $request, $id)
    {
        $alumni = Alumni::findOrFail($id);
        $request->validate([
            'nama' => 'required|string|max:150',
            'jenis_kelamin' => 'nullable|string|max:20',
            'angkatan' => 'required|integer',
            'profesi' => 'nullable|string|max:150',
            'kategori_profesi' => 'nullable|string|max:100',
            'domisili' => 'nullable|string|max:150',
            'no_hp' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:100',
            'foto' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120',
        ]);

        $fotoUrl = $alumni->foto;
        if ($request->hasFile('foto')) {
            $fotoUrl = $this->uploadAndConvertToWebp($request->file('foto'), 'alumni');
        }

        $alumni->update([
            'nama' => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin ?? $alumni->jenis_kelamin,
            'angkatan' => $request->angkatan,
            'profesi' => $request->profesi,
            'kategori_profesi' => $request->kategori_profesi ?? Alumni::getKategoriProfesi($request->profesi),
            'domisili' => $request->domisili,
            'no_hp' => $request->no_hp,
            'email' => $request->email,
            'foto' => $fotoUrl,
        ]);

        return back()->with('success', 'Data alumni berhasil diperbarui!');
    }

    public function approveAlumni($id)
    {
        $alumni = Alumni::findOrFail($id);
        $alumni->update(['status' => 'approved']);

        if (!empty($alumni->no_hp)) {
            $msg = "Halo {$alumni->nama}, pendaftaran Anda di Portal Resmi IKA SMAN Kajuara / SMAN 8 Bone telah disetujui! Data Anda kini telah tampil di direktori alumni.";
            \App\Services\NotificationService::sendWhatsAppNotification($alumni->no_hp, $msg);
        }

        return back()->with('success', "Pendaftaran alumni {$alumni->nama} berhasil disetujui!");
    }

    public function rejectAlumni($id)
    {
        $alumni = Alumni::findOrFail($id);
        $alumni->update(['status' => 'rejected']);
        return back()->with('success', "Pendaftaran alumni {$alumni->nama} ditolak.");
    }

    public function deleteAlumni($id)
    {
        $alumni = Alumni::findOrFail($id);
        $alumni->delete();

        return back()->with('success', 'Data alumni berhasil dihapus!');
    }

    public function bulkDeleteAlumni(Request $request)
    {
        $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'required|string',
        ]);

        $count = Alumni::whereIn('id', $request->ids)->count();
        Alumni::whereIn('id', $request->ids)->delete();

        return back()->with('success', "Berhasil menghapus {$count} data alumni terpilih!");
    }

    // Unduh Template Excel / CSV Pendaftaran Alumni Massal
    public function downloadTemplateAlumni()
    {
        $filename = "Template_Impor_Alumni_IKA_SMAN8_Bone.csv";
        $headers = [
            "Content-type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename={$filename}",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $columns = ['Nama Lengkap', 'Jenis Kelamin', 'Angkatan', 'Profesi', 'Domisili Kota', 'No WhatsApp', 'Email'];
        $sampleData = [
            ['Andi Ahmad Sultan, S.T.', 'Laki-laki', 2015, 'Software Developer', 'Makassar', '081234567890', 'ahmad@example.com'],
            ['Siti Nurhaliza, S.Ked.', 'Perempuan', 2016, 'Dokter Umum', 'Bone', '082198765432', 'siti@example.com'],
        ];

        $callback = function () use ($columns, $sampleData) {
            $file = fopen('php://output', 'w');
            // Write UTF-8 BOM for Excel compatibility
            fputs($file, "\xEF\xBB\xBF");
            fputcsv($file, $columns);
            foreach ($sampleData as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // Pratinjau & Validasi Data Impor Alumni
    public function previewImportAlumni(Request $request)
    {
        $request->validate([
            'file_import' => 'required|file|mimes:csv,txt,xlsx,xls|max:5120',
        ]);

        $file = $request->file('file_import');
        $filePath = $file->getRealPath();

        $rows = [];
        if (($handle = fopen($filePath, 'r')) !== FALSE) {
            // Check for UTF-8 BOM
            $bom = fread($handle, 3);
            if ($bom !== "\xEF\xBB\xBF") {
                rewind($handle);
            }

            $header = fgetcsv($handle, 1000, ',');
            if (!$header || count($header) < 3) {
                rewind($handle);
                $header = fgetcsv($handle, 1000, ';'); // Try semicolon delimiter
            }

            while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                if (count($data) < 3) continue;
                $nama = trim($data[0] ?? '');
                if (empty($nama) || strtolower($nama) == 'nama lengkap') continue;

                $jenisKelamin = trim($data[1] ?? 'Laki-laki');
                $angkatan = intval(trim($data[2] ?? date('Y')));
                $profesi = trim($data[3] ?? '-');
                $domisili = trim($data[4] ?? '-');
                $noHp = trim($data[5] ?? '-');
                $email = trim($data[6] ?? '-');

                // Check existing duplicate name in DB
                $isDuplicate = Alumni::where('nama', 'like', $nama)->exists();

                $rows[] = [
                    'nama' => $nama,
                    'jenis_kelamin' => in_array(strtolower($jenisKelamin), ['perempuan', 'p']) ? 'Perempuan' : 'Laki-laki',
                    'angkatan' => $angkatan > 1950 ? $angkatan : date('Y'),
                    'profesi' => $profesi,
                    'domisili' => $domisili,
                    'no_hp' => $noHp,
                    'email' => $email,
                    'is_duplicate' => $isDuplicate,
                ];
            }
            fclose($handle);
        }

        if (empty($rows)) {
            return back()->with('error', 'File tidak berisi data alumni yang valid. Silakan gunakan template standar.');
        }

        session(['import_preview_rows' => $rows]);
        return back()->with('import_preview_ready', true);
    }

    // Simpan Data Hasil Impor yang Valid ke Database
    public function processImportAlumni(Request $request)
    {
        $rows = session('import_preview_rows', []);
        if (empty($rows)) {
            return back()->with('error', 'Tidak ada data impor yang dapat diproses.');
        }

        $insertedCount = 0;
        foreach ($rows as $row) {
            // Skip duplicate if user unchecked or if force insert
            if (!empty($row['nama'])) {
                Alumni::create([
                    'id' => (string) Str::uuid(),
                    'nama' => $row['nama'],
                    'jenis_kelamin' => $row['jenis_kelamin'],
                    'angkatan' => $row['angkatan'],
                    'profesi' => $row['profesi'],
                    'domisili' => $row['domisili'],
                    'no_hp' => $row['no_hp'],
                    'email' => $row['email'] !== '-' ? $row['email'] : null,
                    'status' => 'approved',
                ]);
                $insertedCount++;
            }
        }

        session()->forget('import_preview_rows');
        return back()->with('success', "Berhasil mengimpor {$insertedCount} data alumni baru ke database!");
    }

    // Ekspor Data Alumni Terfilter ke File Excel/CSV (.csv)
    public function exportExcelAlumni(Request $request)
    {
        $query = Alumni::query();
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('profesi', 'like', "%{$search}%")
                  ->orWhere('domisili', 'like', "%{$search}%");
            });
        }
        if ($request->filled('status') && $request->status !== 'semua') $query->where('status', $request->status);
        if ($request->filled('angkatan')) $query->where('angkatan', $request->angkatan);
        if ($request->filled('domisili')) $query->where('domisili', 'like', "%{$request->domisili}%");
        if ($request->filled('gender')) $query->where('jenis_kelamin', $request->gender);

        $alumniList = $query->orderBy('angkatan', 'desc')->orderBy('nama', 'asc')->get();

        $filename = "Data_Alumni_IKA_SMAN8_Bone_" . date('Ymd_His') . ".csv";
        $headers = [
            "Content-type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename={$filename}",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $columns = ['No', 'Nama Lengkap', 'Jenis Kelamin', 'Angkatan', 'Profesi / Pekerjaan', 'Domisili Kota', 'No WhatsApp / HP', 'Email', 'Status Verifikasi'];

        $callback = function () use ($columns, $alumniList) {
            $file = fopen('php://output', 'w');
            fputs($file, "\xEF\xBB\xBF");
            fputcsv($file, $columns);
            $no = 1;
            foreach ($alumniList as $alm) {
                fputcsv($file, [
                    $no++,
                    $alm->nama,
                    $alm->jenis_kelamin,
                    $alm->angkatan,
                    !empty($alm->profesi) ? $alm->profesi : (!empty($alm->kategori_profesi) ? $alm->kategori_profesi : '-'),
                    $alm->domisili ?? '-',
                    $alm->no_hp ?? '-',
                    $alm->email ?? '-',
                    strtoupper($alm->status ?? 'approved'),
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // Ekspor Data Alumni ke PDF Laporan Cetak Resmi
    public function exportPdfAlumni(Request $request)
    {
        $query = Alumni::query();
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('profesi', 'like', "%{$search}%")
                  ->orWhere('domisili', 'like', "%{$search}%");
            });
        }
        if ($request->filled('status') && $request->status !== 'semua') $query->where('status', $request->status);
        if ($request->filled('angkatan')) $query->where('angkatan', $request->angkatan);
        if ($request->filled('domisili')) $query->where('domisili', 'like', "%{$request->domisili}%");
        if ($request->filled('gender')) $query->where('jenis_kelamin', $request->gender);

        $alumniList = $query->orderBy('angkatan', 'desc')->orderBy('nama', 'asc')->get();

        return view('admin.alumni_pdf', compact('alumniList'));
    }

    // ==================== KELOLA BERITA ====================
    public function berita(Request $request)
    {
        $query = Berita::query();
        if ($request->filled('q')) {
            $query->where('judul', 'like', "%{$request->q}%");
        }
        if ($request->filled('status') && $request->status !== 'semua') {
            $query->where('status', $request->status);
        }
        if ($request->filled('kategori') && $request->kategori !== 'semua') {
            $query->where('kategori', $request->kategori);
        }

        $beritaList = $query->orderBy('created_at', 'desc')->paginate(8)->withQueryString();
        return view('admin.berita_index', compact('beritaList'));
    }

    public function storeBerita(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'ringkasan' => 'required|string',
            'isi' => 'required|string',
            'gambar' => 'required|image|mimes:jpeg,jpg,png,webp|max:5120',
            'penulis' => 'nullable|string|max:100',
            'kategori' => 'nullable|string|max:50',
            'status' => 'nullable|string|max:20',
        ]);

        $gambarUrl = $this->uploadAndConvertToWebp($request->file('gambar'), 'berita');

        Berita::create([
            'id' => (string) Str::uuid(),
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul) . '-' . rand(100, 999),
            'ringkasan' => $request->ringkasan,
            'isi' => $request->isi,
            'gambar' => $gambarUrl,
            'penulis' => $request->penulis ?? 'Humas IKA',
            'kategori' => $request->kategori ?? 'Berita',
            'status' => $request->status ?? 'published',
        ]);

        return back()->with('success', 'Berita baru berhasil diterbitkan dengan gambar WebP!');
    }

    public function updateBerita(Request $request, $id)
    {
        $berita = Berita::findOrFail($id);
        $request->validate([
            'judul' => 'required|string|max:255',
            'ringkasan' => 'required|string',
            'isi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120',
            'penulis' => 'nullable|string|max:100',
            'kategori' => 'nullable|string|max:50',
            'status' => 'nullable|string|max:20',
        ]);

        $gambarUrl = $berita->gambar;
        if ($request->hasFile('gambar')) {
            $gambarUrl = $this->uploadAndConvertToWebp($request->file('gambar'), 'berita');
        }

        $berita->update([
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'ringkasan' => $request->ringkasan,
            'isi' => $request->isi,
            'gambar' => $gambarUrl,
            'penulis' => $request->penulis ?? 'Humas IKA',
            'kategori' => $request->kategori ?? $berita->kategori ?? 'Berita',
            'status' => $request->status ?? $berita->status ?? 'published',
        ]);

        return back()->with('success', 'Berita berhasil diperbarui!');
    }

    public function deleteBerita($id)
    {
        $berita = Berita::findOrFail($id);
        $berita->delete();
        return back()->with('success', 'Berita berhasil dihapus!');
    }

    // Helper ekstrak YouTube Thumbnail HD
    private function getYouTubeThumbnail($url)
    {
        if (empty($url)) return null;
        if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)) {
            return "https://img.youtube.com/vi/{$match[1]}/hqdefault.jpg";
        }
        return null;
    }

    // ==================== KELOLA GALERI ====================
    public function galeri(Request $request)
    {
        $query = Galeri::query();

        if ($request->filled('q')) {
            $query->where(function($q) use ($request) {
                $q->where('judul', 'like', "%{$request->q}%")
                  ->orWhere('deskripsi', 'like', "%{$request->q}%");
            });
        }

        if ($request->filled('kategori') && $request->kategori !== 'semua') {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('tipe') && $request->tipe !== 'semua') {
            $query->where('tipe', $request->tipe);
        }

        $allGaleri = $query->orderBy('created_at', 'desc')->get();
        $groupedAlbums = $allGaleri->groupBy('judul');

        $existingKategori = Galeri::distinct()->whereNotNull('kategori')->pluck('kategori')->toArray();
        $defaultKategori = ['Umum', 'Rapat Pengurus', 'Kegiatan', 'Beasiswa'];
        $kategoriList = array_values(array_unique(array_merge($defaultKategori, $existingKategori)));

        return view('admin.galeri_index', compact('groupedAlbums', 'kategoriList'));
    }

    public function storeGaleri(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kategori' => 'required|string|max:50',
            'tipe' => 'required|string',
        ]);

        $count = 0;

        if ($request->tipe === 'video') {
            $request->validate([
                'video_url' => 'required|string',
            ]);

            $gambarUrl = null;
            if ($request->hasFile('gambar_sampul')) {
                $gambarUrl = $this->uploadAndConvertToWebp($request->file('gambar_sampul'), 'galeri');
            } else {
                $gambarUrl = $this->getYouTubeThumbnail($request->video_url);
            }

            Galeri::create([
                'id' => (string) Str::uuid(),
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'gambar' => $gambarUrl ?? '',
                'video_url' => $request->video_url,
                'kategori' => $request->kategori,
                'is_cover' => 1,
                'tipe' => 'video',
            ]);
            $count++;
        } else {
            // Tipe Foto: 1. Foto Sampul (Cover)
            if ($request->hasFile('gambar_sampul')) {
                $coverUrl = $this->uploadAndConvertToWebp($request->file('gambar_sampul'), 'galeri');
                Galeri::create([
                    'id' => (string) Str::uuid(),
                    'judul' => $request->judul,
                    'deskripsi' => $request->deskripsi,
                    'gambar' => $coverUrl,
                    'kategori' => $request->kategori,
                    'is_cover' => 1,
                    'tipe' => 'foto',
                ]);
                $count++;
            }

            // 2. Foto-foto Dokumentasi Tambahan
            if ($request->hasFile('gambar_lainnya')) {
                $files = $request->file('gambar_lainnya');
                if (!is_array($files)) {
                    $files = [$files];
                }
                foreach ($files as $file) {
                    if ($file && $file->isValid()) {
                        $gambarUrl = $this->uploadAndConvertToWebp($file, 'galeri');
                        Galeri::create([
                            'id' => (string) Str::uuid(),
                            'judul' => $request->judul,
                            'deskripsi' => $request->deskripsi,
                            'gambar' => $gambarUrl,
                            'kategori' => $request->kategori,
                            'is_cover' => 0,
                            'tipe' => 'foto',
                        ]);
                        $count++;
                    }
                }
            }
        }

        return back()->with('success', "Berhasil menyimpan {$count} item galeri kegiatan!");
    }

    public function updateGaleri(Request $request, $id)
    {
        $galeri = Galeri::findOrFail($id);
        $oldJudul = $galeri->judul;

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kategori' => 'required|string|max:50',
            'tipe' => 'required|string',
            'video_url' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120',
        ]);

        $gambarUrl = $galeri->gambar;
        if ($request->hasFile('gambar')) {
            $gambarUrl = $this->uploadAndConvertToWebp($request->file('gambar'), 'galeri');
        } elseif ($request->tipe === 'video' && !empty($request->video_url)) {
            $ytThumb = $this->getYouTubeThumbnail($request->video_url);
            if ($ytThumb && (empty($gambarUrl) || str_contains($gambarUrl, 'img.youtube.com'))) {
                $gambarUrl = $ytThumb;
            }
        }

        // Update seluruh foto/item dalam album yang sama agar tidak terpecah/double
        if (!empty($oldJudul)) {
            Galeri::where('judul', $oldJudul)->update([
                'judul' => $request->judul,
                'kategori' => $request->kategori,
                'deskripsi' => $request->deskripsi,
            ]);
        }

        // Update data spesifik item ini (seperti foto/video_url/tipe)
        $galeri->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'gambar' => $gambarUrl,
            'video_url' => $request->video_url,
            'kategori' => $request->kategori,
            'tipe' => $request->tipe,
        ]);

        return back()->with('success', 'Album galeri berhasil diperbarui!');
    }

    public function deleteGaleri($id)
    {
        $galeri = Galeri::findOrFail($id);

        if (request()->has('delete_album')) {
            $count = Galeri::where('judul', $galeri->judul)->count();
            Galeri::where('judul', $galeri->judul)->delete();
            return back()->with('success', "Seluruh album '{$galeri->judul}' ({$count} foto) berhasil dihapus!");
        }

        $galeri->delete();
        return back()->with('success', 'Foto galeri berhasil dihapus!');
    }

    // ==================== KELOLA PENGURUS ====================
    public function pengurus()
    {
        $pengurusList = Pengurus::with('bidang')->orderBy('urutan', 'asc')->get();
        $bidangList = Bidang::orderBy('urutan', 'asc')->get();
        return view('admin.pengurus_index', compact('pengurusList', 'bidangList'));
    }

    public function storePengurus(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:150',
            'jabatan' => 'required|string|max:100',
            'id_bidang' => 'required|integer',
            'periode' => 'nullable|string|max:20',
            'foto' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120',
            'sosmed_instagram' => 'nullable|string|max:150',
            'sosmed_linkedin' => 'nullable|string|max:150',
            'deskripsi_tugas' => 'nullable|string',
            'is_inti' => 'required|boolean',
        ]);

        $fotoUrl = null;
        if ($request->hasFile('foto')) {
            $fotoUrl = $this->uploadAndConvertToWebp($request->file('foto'), 'pengurus');
        }

        Pengurus::create([
            'id' => (string) Str::uuid(),
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'id_bidang' => $request->id_bidang,
            'periode' => $request->periode ?? '2026-2031',
            'foto' => $fotoUrl,
            'sosmed_instagram' => $request->sosmed_instagram,
            'sosmed_linkedin' => $request->sosmed_linkedin,
            'deskripsi_tugas' => $request->deskripsi_tugas,
            'is_inti' => $request->is_inti,
            'urutan' => Pengurus::count() + 1,
        ]);

        return back()->with('success', 'Data pengurus baru & foto berhasil disimpan!');
    }

    public function updatePengurus(Request $request, $id)
    {
        $pengurus = Pengurus::findOrFail($id);
        $request->validate([
            'nama' => 'required|string|max:150',
            'jabatan' => 'required|string|max:100',
            'id_bidang' => 'required|integer',
            'periode' => 'nullable|string|max:20',
            'foto' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120',
            'sosmed_instagram' => 'nullable|string|max:150',
            'sosmed_linkedin' => 'nullable|string|max:150',
            'deskripsi_tugas' => 'nullable|string',
            'is_inti' => 'required|boolean',
        ]);

        $fotoUrl = $pengurus->foto;
        if ($request->hasFile('foto')) {
            $fotoUrl = $this->uploadAndConvertToWebp($request->file('foto'), 'pengurus');
        }

        $pengurus->update([
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'id_bidang' => $request->id_bidang,
            'periode' => $request->periode ?? $pengurus->periode,
            'foto' => $fotoUrl,
            'sosmed_instagram' => $request->sosmed_instagram,
            'sosmed_linkedin' => $request->sosmed_linkedin,
            'deskripsi_tugas' => $request->deskripsi_tugas,
            'is_inti' => $request->is_inti,
        ]);

        return back()->with('success', 'Data pengurus berhasil diperbarui!');
    }

    public function deletePengurus($id)
    {
        $pengurus = Pengurus::findOrFail($id);
        $pengurus->delete();
        return back()->with('success', 'Data pengurus berhasil dihapus!');
    }

    // ==================== KELOLA KATEGORI BERITA ====================
    public function kategoriBerita(Request $request)
    {
        $query = KategoriBerita::query();
        if ($request->filled('q')) {
            $query->where('nama_kategori', 'like', "%{$request->q}%");
        }
        $kategoriList = $query->orderBy('nama_kategori', 'asc')->paginate(10)->withQueryString();
        return view('admin.kategori_berita_index', compact('kategoriList'));
    }

    public function storeKategoriBerita(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
        ]);

        KategoriBerita::create([
            'nama_kategori' => $request->nama_kategori,
            'slug' => Str::slug($request->nama_kategori),
            'deskripsi' => $request->deskripsi,
        ]);

        return back()->with('success', 'Kategori berita baru berhasil ditambahkan!');
    }

    public function updateKategoriBerita(Request $request, $id)
    {
        $kategori = KategoriBerita::findOrFail($id);
        $request->validate([
            'nama_kategori' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
        ]);

        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
            'slug' => Str::slug($request->nama_kategori),
            'deskripsi' => $request->deskripsi,
        ]);

        return back()->with('success', 'Kategori berita berhasil diperbarui!');
    }

    public function deleteKategoriBerita($id)
    {
        $kategori = KategoriBerita::findOrFail($id);
        $kategori->delete();
        return back()->with('success', 'Kategori berita berhasil dihapus!');
    }

    // ==================== KELOLA PENGGUNA (USER MANAGEMENT) ====================
    public function users(Request $request)
    {
        $query = User::query();
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        $usersList = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        return view('admin.users_index', compact('usersList'));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:50|unique:sys_users,username',
            'full_name' => 'required|string|max:100',
            'email' => 'nullable|email|max:100',
            'password' => 'required|string|min:6',
            'role' => 'required|string|max:20',
        ]);

        User::create([
            'id' => (string) Str::uuid(),
            'username' => $request->username,
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return back()->with('success', 'Pengguna admin baru berhasil ditambahkan!');
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'username' => 'required|string|max:50|unique:sys_users,username,' . $id,
            'full_name' => 'required|string|max:100',
            'email' => 'nullable|email|max:100',
            'password' => 'nullable|string|min:6',
            'role' => 'required|string|max:20',
        ]);

        $data = [
            'username' => $request->username,
            'full_name' => $request->full_name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return back()->with('success', 'Data pengguna admin berhasil diperbarui!');
    }

    public function deleteUser($id)
    {
        if ($id == Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif!');
        }

        $user = User::findOrFail($id);
        $user->delete();
        return back()->with('success', 'Pengguna admin berhasil dihapus!');
    }

    // ==================== KELOLA BEASISWA ====================
    public function beasiswa(Request $request)
    {
        $query = Beasiswa::query();

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('informasi', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status') && $request->status !== 'semua') {
            $query->where('status', $request->status);
        }

        $beasiswaList = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        return view('admin.beasiswa_index', compact('beasiswaList'));
    }

    public function storeBeasiswa(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'informasi' => 'required|string',
            'link_eksternal' => 'required|url|max:500',
            'gambar' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120',
            'status' => 'nullable|string|max:20',
        ]);

        $gambarUrl = null;
        if ($request->hasFile('gambar')) {
            $gambarUrl = $this->uploadAndConvertToWebp($request->file('gambar'), 'beasiswa');
        }

        Beasiswa::create([
            'id' => (string) Str::uuid(),
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul) . '-' . rand(100, 999),
            'informasi' => $request->informasi,
            'link_eksternal' => $request->link_eksternal,
            'gambar' => $gambarUrl,
            'status' => $request->status ?? 'published',
        ]);

        return back()->with('success', 'Informasi beasiswa baru berhasil ditambahkan!');
    }

    public function updateBeasiswa(Request $request, $id)
    {
        $beasiswa = Beasiswa::findOrFail($id);
        $request->validate([
            'judul' => 'required|string|max:255',
            'informasi' => 'required|string',
            'link_eksternal' => 'required|url|max:500',
            'gambar' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120',
            'status' => 'nullable|string|max:20',
        ]);

        $gambarUrl = $beasiswa->gambar;
        if ($request->hasFile('gambar')) {
            $gambarUrl = $this->uploadAndConvertToWebp($request->file('gambar'), 'beasiswa');
        }

        $beasiswa->update([
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'informasi' => $request->informasi,
            'link_eksternal' => $request->link_eksternal,
            'gambar' => $gambarUrl,
            'status' => $request->status ?? $beasiswa->status ?? 'published',
        ]);

        return back()->with('success', 'Informasi beasiswa berhasil diperbarui!');
    }

    public function deleteBeasiswa($id)
    {
        $beasiswa = Beasiswa::findOrFail($id);
        $beasiswa->delete();
        return back()->with('success', 'Informasi beasiswa berhasil dihapus!');
    }

    // ==================== KELOLA INFOGRAFIS & POPUP FLYER ====================
    public function infografis(Request $request)
    {
        $query = Infografis::query();

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status') && $request->status !== 'semua') {
            $query->where('status', $request->status);
        }

        $infografisList = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        $popupCount = Infografis::where('is_popup', 1)->where('status', 'published')->count();

        return view('admin.infografis_index', compact('infografisList', 'popupCount'));
    }

    public function storeInfografis(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'link_tautan' => 'nullable|string|max:500',
            'gambar' => 'required|image|mimes:jpeg,jpg,png,webp|max:10240',
            'is_popup' => 'nullable|boolean',
            'status' => 'nullable|string|max:20',
        ], [
            'judul.required' => 'Judul infografis / flyer wajib diisi!',
            'gambar.required' => 'File gambar flyer wajib diunggah!',
            'gambar.image' => 'File yang diunggah harus berupa gambar (JPG, PNG, WEBP).',
            'gambar.mimes' => 'Format gambar harus JPEG, JPG, PNG, atau WEBP.',
            'gambar.max' => 'Ukuran file gambar terlalu besar! Maksimal ukuran file yang diperbolehkan adalah 10 MB.',
        ]);

        $linkTautan = $request->link_tautan;
        if ($linkTautan && !preg_match("~^(?:f|ht)tps?://~i", $linkTautan)) {
            $linkTautan = "https://" . $linkTautan;
        }

        $isPopup = $request->has('is_popup') ? 1 : 0;
        if ($isPopup == 1) {
            $currentActiveCount = Infografis::where('is_popup', 1)->where('status', 'published')->count();
            if ($currentActiveCount >= 3) {
                return back()->with('error', 'Gagal mengaktifkan Popup: Maksimal 3 Flyer Announcement Popup yang dapat diaktifkan bersamaan! Silakan nonaktifkan salah satu flyer terlebih dahulu.')->withInput();
            }
        }

        $gambarUrl = $this->uploadAndConvertToWebp($request->file('gambar'), 'infografis');

        Infografis::create([
            'id' => (string) Str::uuid(),
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul) . '-' . rand(100, 999),
            'deskripsi' => $request->deskripsi,
            'gambar' => $gambarUrl,
            'link_tautan' => $linkTautan,
            'is_popup' => $isPopup,
            'status' => $request->status ?? 'published',
        ]);

        return back()->with('success', 'Infografis / Flyer baru berhasil ditambahkan!');
    }

    public function updateInfografis(Request $request, $id)
    {
        $infografis = Infografis::findOrFail($id);
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'link_tautan' => 'nullable|string|max:500',
            'gambar' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:10240',
            'is_popup' => 'nullable|boolean',
            'status' => 'nullable|string|max:20',
        ], [
            'judul.required' => 'Judul infografis / flyer wajib diisi!',
            'gambar.image' => 'File yang diunggah harus berupa gambar (JPG, PNG, WEBP).',
            'gambar.mimes' => 'Format gambar harus JPEG, JPG, PNG, atau WEBP.',
            'gambar.max' => 'Ukuran file gambar terlalu besar! Maksimal ukuran file yang diperbolehkan adalah 10 MB.',
        ]);

        $linkTautan = $request->link_tautan;
        if ($linkTautan && !preg_match("~^(?:f|ht)tps?://~i", $linkTautan)) {
            $linkTautan = "https://" . $linkTautan;
        }

        $isPopup = $request->has('is_popup') ? 1 : 0;
        if ($isPopup == 1 && !$infografis->is_popup) {
            $currentActiveCount = Infografis::where('is_popup', 1)->where('status', 'published')->count();
            if ($currentActiveCount >= 3) {
                return back()->with('error', 'Gagal mengaktifkan Popup: Maksimal 3 Flyer Announcement Popup yang dapat diaktifkan bersamaan!')->withInput();
            }
        }

        $gambarUrl = $infografis->gambar;
        if ($request->hasFile('gambar')) {
            $gambarUrl = $this->uploadAndConvertToWebp($request->file('gambar'), 'infografis');
        }

        $infografis->update([
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'deskripsi' => $request->deskripsi,
            'gambar' => $gambarUrl,
            'link_tautan' => $linkTautan,
            'is_popup' => $isPopup,
            'status' => $request->status ?? $infografis->status ?? 'published',
        ]);

        return back()->with('success', 'Data infografis berhasil diperbarui!');
    }

    public function togglePopupInfografis($id)
    {
        $infografis = Infografis::findOrFail($id);
        $newStatus = $infografis->is_popup ? 0 : 1;

        // Cek kuota jika mengaktifkan popup
        if ($newStatus == 1) {
            $currentActiveCount = Infografis::where('is_popup', 1)->where('status', 'published')->count();
            if ($currentActiveCount >= 3) {
                return back()->with('error', 'Maksimal 3 Flyer Announcement Popup yang dapat diaktifkan bersamaan!');
            }
        }

        $infografis->update(['is_popup' => $newStatus]);
        $statusMsg = $newStatus ? 'diaktifkan sebagai Popup Flyer Beranda!' : 'dinonaktifkan dari Popup Flyer Beranda.';

        return back()->with('success', "Infografis '{$infografis->judul}' berhasil {$statusMsg}");
    }

    public function deleteInfografis($id)
    {
        $infografis = Infografis::findOrFail($id);
        $infografis->delete();
        return back()->with('success', 'Infografis berhasil dihapus!');
    }
}
