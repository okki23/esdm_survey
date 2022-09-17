<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\ObservantTrait;

class Score extends Model
{
    use HasFactory, SoftDeletes, ObservantTrait;

    protected $table = 'score_kuis';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'kriteria',
        'rentang_nilai_minimum',
        'rentang_nilai_maksimum'
    ];
}
