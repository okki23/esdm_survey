<?php
namespace App\Transformer;

use League\Fractal\TransformerAbstract;
use App\Models\Peserta;

class PesertaTransformer extends TransformerAbstract
{
    public function transform(Peserta $query)
    {
        return [
            'id' => (int) $query->id,
            'id_unit' => (int) $query->id_unit,
            'nomor_peserta' => (string) $query->nomor_peserta,
            'nama_peserta' => (string) $query->nama_peserta,
            'email' => (string) $query->email,
            'telp' => (string) $query->telp,
            'unit' => $query->unit
        ];
    }
}
