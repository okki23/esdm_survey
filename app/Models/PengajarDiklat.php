<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\ObservantTrait;

class PengajarDiklat extends Model
{
    use HasFactory, SoftDeletes, ObservantTrait;

    protected $table = 'tbl_pengajar_diklat';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'id_diklat',
        'id_pengajar'
    ];

    public function Pengajar()
    {
        return $this->hasOne(Pengajar::class,'id', 'id_pengajar');
    }
}
