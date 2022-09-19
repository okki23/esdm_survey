<?php
namespace App\Transformer;

use League\Fractal\TransformerAbstract;
use App\Models\JadwalKuis;

class JadwalKuisTransformer extends TransformerAbstract
{
    public function transform(JadwalKuis $query)
    {
        return [
            'id' => (int) $query->id,
            'id_template_survey_kuis' => (int) $query->id_template_survey_kuis,
            'tgl_kuis_mulai' => (string) $query->tgl_kuis_mulai,
            'tgl_kuis_selesai' => (string) $query->tgl_kuis_selesai,
            'id_pic'=> (int) $query->id_pic,
            'created_at' => (string) $query->created_at
        ];
    }
}
