<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\ObservantTrait;

class Pic extends Model
{
    use HasFactory, SoftDeletes, ObservantTrait;

    protected $table = 'pic';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_unit',
        'nama_pic',
        'telp'
    ];

    public function Unit()
    {
        return $this->hasOne(Unit::class,'id', 'id_unit');
    }
}
