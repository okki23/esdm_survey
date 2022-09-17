<?php
namespace App\Transformer;

use App\Models\Kategori;
use League\Fractal\TransformerAbstract;


class KategoriTransformer extends TransformerAbstract
{
    public function transform(Kategori $query)
    {
        return [
            'id' => (int) $query->id,
            'kategori' => (string) $query->kategori,
            'status' => (bool) $query->status,
        ];
    }
}
