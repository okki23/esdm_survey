<?php
namespace App\Transformer;

use League\Fractal\TransformerAbstract;
use App\Models\Pengajar;

class PengajarTransformer extends TransformerAbstract
{
    public function transform(Pengajar $query)
    {
        return [
            'id' => (int) $query->id,
            'nik' => (string) $query->nik,
            'nama_pengajar' => (string) $query->nama_pengajar,
            'kode_pengajar' => (string) $query->kode_pengajar,
            'id_unit' => (int) $query->id_unit,
            'created_at' => (string) $query->created_at,
            'unit' => (object) $query->unit
        ];
    }
}