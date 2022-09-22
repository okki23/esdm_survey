<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\ObservantTrait;

class Evaluasi extends Model
{
    use HasFactory, SoftDeletes, ObservantTrait;

    protected $table = 'evaluasi';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_kategori',
        'judul_evaluasi',
        'id_diklat'
    ];

    public function Kategori()
    {
        return $this->hasOne(Kategori::class,'id', 'id_kategori')->select('kategori');
    }

    public function Diklat()
    {
        return $this->hasOne(Diklat::class,'id', 'id_diklat')->select('judul_diklat');
    }
}
