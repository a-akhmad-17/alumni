<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Infografis extends Model
{
    use HasFactory, SoftDeletes, \App\Traits\HasImageAttribute;

    protected $table = 'trn_infografis';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'judul',
        'slug',
        'deskripsi',
        'gambar',
        'link_tautan',
        'is_popup',
        'urutan',
        'status',
    ];

    protected $dates = ['deleted_at'];

    public function getGambarAttribute($value)
    {
        return self::normalizeImageUrl($value);
    }
}
