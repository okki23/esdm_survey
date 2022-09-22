<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\ObservantTrait;

class Peserta extends Model
{
    use HasFactory, SoftDeletes, ObservantTrait;

    protected $table = 'peserta';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'nomor_peserta',
        'nama_peserta',
        'email',
        'telp',
        'id_unit'
    ];

    public function Unit()
    {
        return $this->hasOne(Unit::class,'id', 'id_unit')->select('kode_unit', 'nama_unit');
    }
}
