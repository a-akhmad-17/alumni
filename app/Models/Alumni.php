<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Alumni extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'mst_alumni';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'nama',
        'jenis_kelamin',
        'angkatan',
        'profesi',
        'kategori_profesi',
        'domisili',
        'no_hp',
        'email',
        'is_berprestasi',
        'deskripsi_prestasi',
        'foto',
        'status',
    ];

    protected $dates = ['deleted_at'];

    /**
     * Helper Kategori Profesi Utama (Grouped) untuk Grafik & Statistik
     */
    public static function getKategoriProfesi($profesi, $kategoriProfesi = null)
    {
        if (!empty($kategoriProfesi)) {
            return $kategoriProfesi;
        }

        if (empty($profesi)) return 'Lainnya';

        $p = strtolower($profesi);

        if (preg_match('/(tni|polri|polisi|tentara|polda|polres|polsek|bripka|akbp|mayor|kapt|serda|letda|kolonel|jenderal|perwira|penyidik)/i', $p)) {
            return 'TNI / Polri';
        }
        if (preg_match('/(dokter|spesialis|apoteker|farmasi|perawat|bidan|kesehatan|medis|co-ass|sp\.pd)/i', $p)) {
            return 'Tenaga Kesehatan';
        }
        if (preg_match('/(dosen|guru|akademisi|pengajar|pendidik|m\.ed|m\.pd|profesor|peneliti)/i', $p)) {
            return 'Akademisi & Pendidik';
        }
        if (preg_match('/(notaris|ppat|advokat|pengacara|hukum|jaksa|hakim|s\.h|m\.kn)/i', $p)) {
            return 'Hukum & Legal';
        }
        if (preg_match('/(politisi|dpr|dprd|parlemen|partai|bupati|walikota)/i', $p)) {
            return 'Politisi & Pemerintahan';
        }
        if (preg_match('/(entrepreneur|wiraswasta|pengusaha|ceo|founder|owner|pemilik|bisnis|pedagang|umkm)/i', $p)) {
            return 'Wiraswasta / Pengusaha';
        }
        if (preg_match('/(pns|asn|kementerian|dinas|pemerintah|pamong|lurah|camat)/i', $p)) {
            return 'ASN / PNS & Birokrasi';
        }

        return 'Swasta & BUMN';
    }
}
