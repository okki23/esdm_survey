<?php
namespace App\Transformer;

use League\Fractal\TransformerAbstract;
use App\Models\TipeKuis;

class TipeKuisTransformer extends TransformerAbstract
{
    public function transform(TipeKuis $query)
    {
        return [
            'id' => (int) $query->id,
            'nama_tipe' => (string) $query->nama_tipe,
            'status' => (boolean) $query->status,
            'created_at' => (string) $query->created_at
        ];
    }
}