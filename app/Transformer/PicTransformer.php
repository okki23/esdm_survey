<?php
namespace App\Transformer;

use League\Fractal\TransformerAbstract;
use App\Models\Pic;

class PicTransformer extends TransformerAbstract
{
    public function transform(Pic $query)
    {
        return [
            'id' => (int) $query->id,
            'id_unit' => (int) $query->id_unit,
            'nama_pic' => (string) $query->nama_pic,
            'telp' => (string) $query->telp,
            'created_at' => (string) $query->created_at,
            'unit' => (object) $query->unit
        ];
    }
}