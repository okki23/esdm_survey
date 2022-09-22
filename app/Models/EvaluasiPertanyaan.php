<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\ObservantTrait;

class EvaluasiPertanyaan extends Model
{
    use HasFactory, SoftDeletes, ObservantTrait;

    protected $table = 'evaluasi_pertanyaan';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_evaluasi_pertanyaan',
        'id_aspek_pertanyaan',
        'id_template_pertanyaan'
    ];
}
