<?php
namespace App\Transformer;

use League\Fractal\TransformerAbstract;
use App\Models\Evaluasi;

class EvaluasiTransformer extends TransformerAbstract
{
    public function transform(Evaluasi $query)
    {
        return [
            'id' => (int) $query->id,
            'id_kategori' => (int) $query->id_kategori,
            'judul_evaluasi' => (string) $query->judul_evaluasi,
            'id_diklat' => (int) $query->id_diklat,
            'created_at' => (string) $query->created_at,
            'kategori' => $query->kategori,
            'diklat' => $query->diklat
        ];
    }
}