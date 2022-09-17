<?php
namespace App\Transformer;

use League\Fractal\TransformerAbstract;
use App\Models\Jabatan;

class JabatanTransformer extends TransformerAbstract
{
    public function transform(Jabatan $query)
    {
        return [
            'id' => (int) $query->id,
            'jabatan' => (string) $query->jabatan,
            'status' => (boolean) $query->status,
        ];
    }
}