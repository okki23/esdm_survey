<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\ObservantTrait;

class JadwalKuis extends Model
{
    use HasFactory, SoftDeletes, ObservantTrait;

    protected $table = 'tbl_jadwal_kuis';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_template_survey_kuis',
        'tgl_kuis_mulai',
        'tgl_kuis_selesai',
        'id_pic'
    ];


}
