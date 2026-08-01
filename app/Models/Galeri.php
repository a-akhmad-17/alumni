<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Galeri extends Model
{
    use HasFactory, SoftDeletes, \App\Traits\HasImageAttribute;

    protected $table = 'trn_galeri';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false; // created_at only

    protected $fillable = [
        'id',
        'judul',
        'deskripsi',
        'gambar',
        'video_url',
        'kategori',
        'is_cover',
        'tipe',
    ];

    public function getGambarAttribute($value)
    {
        return self::normalizeImageUrl($value);
    }
}
