<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengurus extends Model
{
    use HasFactory, SoftDeletes, \App\Traits\HasImageAttribute;

    protected $table = 'mst_pengurus';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'nama',
        'jabatan',
        'id_bidang',
        'periode',
        'foto',
        'sosmed_instagram',
        'sosmed_linkedin',
        'deskripsi_tugas',
        'urutan',
        'is_inti',
    ];

    public function getFotoAttribute($value)
    {
        return self::normalizeImageUrl($value);
    }

    public function bidang()
    {
        return $this->belongsTo(Bidang::class, 'id_bidang', 'id');
    }
}
