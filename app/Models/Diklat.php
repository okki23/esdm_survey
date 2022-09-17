<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\ObservantTrait;

class Diklat extends Model
{
    use HasFactory, SoftDeletes, ObservantTrait;

    protected $table = 'diklat';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'judul_diklat',
        'tgl_pelaksanaan_awal',
        'tgl_pelaksanaan_selesai',
        'tempat_diklat',
        'id_jenis_diklat'
    ];

    public function JenisDiklat()
    {
        return $this->hasOne(JenisDiklat::class,'id', 'id_jenis_diklat');
    }
}
