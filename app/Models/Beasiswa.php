<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Beasiswa extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'trn_beasiswa';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'judul',
        'slug',
        'informasi',
        'link_eksternal',
        'gambar',
        'status',
    ];

    protected $dates = ['deleted_at'];
}
