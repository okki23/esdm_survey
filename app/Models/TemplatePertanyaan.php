<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\ObservantTrait;

class TemplatePertanyaan extends Model
{
    use HasFactory, SoftDeletes, ObservantTrait;

    protected $table = 'template_pertanyaan';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_aspek_pertanyaan',
        'id_tipe_kuis',
        'pertanyaan',
        'is_required'
    ];

    public function AspekPertanyaan()
    {
        return $this->hasOne(AspekPertanyaan::class,'id', 'id_aspek_pertanyaan');
    }

    public function TipeKuis()
    {
        return $this->hasOne(TipeKuis::class,'id', 'id_tipe_kuis');
    }

    public function Addon()
    {
        return $this->hasMany(Addon::class, 'id_template_pertanyaan');
    }
}
