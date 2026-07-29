<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Berita extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'trn_berita';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'judul',
        'slug',
        'ringkasan',
        'isi',
        'gambar',
        'penulis',
        'kategori',
        'status',
    ];
}
