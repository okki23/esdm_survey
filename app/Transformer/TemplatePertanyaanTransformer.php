<?php
namespace App\Transformer;

use League\Fractal\TransformerAbstract;
use App\Models\TemplatePertanyaan;

class TemplatePertanyaanTransformer extends TransformerAbstract
{
    public function transform(TemplatePertanyaan $query)
    {
        return [
            'id' => (int) $query->id,
            'id_aspek_pertanyaan' => (int) $query->id_aspek_pertanyaan,
            'id_tipe_kuis' => (int) $query->id_tipe_kuis,
            'pertanyaan' => (string) $query->pertanyaan,
            'is_reqired' => (bool) $query->is_required,
            'created_at' => (string) $query->created_at,
            'aspek_pertanyaan' => (object) $query->aspekPertanyaan,
            'tipe_kuis' => (object) $query->tipeKuis,
            'addon' => $query->addon
        ];
    }
}