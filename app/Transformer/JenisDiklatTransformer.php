<?php
namespace App\Transformer;

use League\Fractal\TransformerAbstract;
use App\Models\JenisDiklat;

class JenisDiklatTransformer extends TransformerAbstract
{
    public function transform(JenisDiklat $query)
    {
        return [
            'id' => (int) $query->id,
            'jenis_diklat' => (string) $query->jenis_diklat,
            'created_at' => (string) $query->created_at,
        ];
    }
}