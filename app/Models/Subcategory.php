<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\ObservantTrait;

class Subcategory extends Model
{
    use HasFactory, SoftDeletes, ObservantTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id',
        'subcategory_name',
        'status'
    ];

    public function Category()
    {
        return $this->hasOne(Category::class,'id', 'category_id');
    }
}
