<?php
namespace App\Transformer;

use League\Fractal\TransformerAbstract;
use App\Models\Unit;

class UnitTransformer extends TransformerAbstract
{
    public function transform(Unit $query)
    {
        return [
            'id' => (int) $query->id,
            'kode_unit' => (string) $query->kode_unit,
            'nama_unit' => (string) $query->nama_unit,
            'created_at' => (string) $query->created_at
        ];
    }
}