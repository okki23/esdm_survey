<?php
namespace App\Transformer;

use League\Fractal\TransformerAbstract;
use App\Models\Score;

class ScoreTransformer extends TransformerAbstract
{
    public function transform(Score $query)
    {
        return [
            'id' => (int) $query->id,
            'kriteria' => (string) $query->kriteria,
            'rentang_nilai_minimum' => (string) $query->rentang_nilai_minimum,
            'rentang_nilai_maksimum' => (string) $query->rentang_nilai_maksimum,
            'created_at' => (string) $query->created_at
        ];
    }
}