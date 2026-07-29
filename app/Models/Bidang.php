<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bidang extends Model
{
    use HasFactory;

    protected $table = 'mst_bidang';
    public $timestamps = false;

    protected $fillable = [
        'nama_bidang',
        'urutan',
        'deskripsi',
    ];

    public function pengurus()
    {
        return $this->hasMany(Pengurus::class, 'id_bidang', 'id');
    }
}
