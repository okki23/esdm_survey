<?php
namespace App\Transformer;

use League\Fractal\TransformerAbstract;
use App\Models\AspekPertanyaan;

class AspekPertanyaanTransformer extends TransformerAbstract
{
    public function transform(AspekPertanyaan $query)
    {
        return [
            'id' => (int) $query->id,
            'id_kategori' => (int) $query->id_kategori,
            'pertanyaan' => (string) $query->pertanyaan,
            'id_tipe_kuis' => (int) $query->id_tipe_kuis,
            'created_at' => (string) $query->created_at,
            'kategori' => (object) $query->kategori,
            'tipe_kuis' => (object) $query->tipe_kuis
        ];
    }
}