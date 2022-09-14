<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\ObservantTrait;

class Pengajar extends Model
{
    use HasFactory, SoftDeletes, ObservantTrait;

    protected $table = 'pengajar';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nik',
        'kode_pengajar',
        'nama_pengajar',
        'email',
        'id_unit'
    ];

    public function Unit()
    {
        return $this->hasOne(Unit::class,'id', 'id_unit');
    }
}
