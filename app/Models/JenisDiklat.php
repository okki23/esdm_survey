<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\ObservantTrait;

class JenisDiklat extends Model
{
    use HasFactory, SoftDeletes, ObservantTrait;

    protected $table = 'jenis_diklat';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'jenis_diklat'
    ];
}
