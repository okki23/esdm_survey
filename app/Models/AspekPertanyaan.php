<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\ObservantTrait;

class AspekPertanyaan extends Model
{
    use HasFactory, SoftDeletes, ObservantTrait;

    protected $table = 'aspek_pertanyaan';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_kategori',
        'pertanyaan',
        'id_tipe_kuis'
    ];

    public function Kategori()
    {
        return $this->hasOne(Kategori::class,'id', 'id_kategori');
    }

    public function TipeKuis()
    {
        return $this->hasOne(TipeKuis::class,'id', 'id_tipe_kuis');
    }
}
