<?php
namespace App\Transformer;

use League\Fractal\TransformerAbstract;
use App\Models\Diklat;

class DiklatTransformer extends TransformerAbstract
{
    public function transform(Diklat $query)
    {
        return [
            'id' => (int) $query->id,
            'judul_diklat' => (string) $query->judul_diklat,
            'tgl_pelaksanaan_awal' => (string) $query->tgl_pelaksanaan_awal,
            'tgl_pelaksanaan_selesai' => (string) $query->tgl_pelaksanaan_selesai,
            'tempat_diklat' => (string) $query->tempat_diklat,
            'jenis_diklat' => (string) $query->jenis_diklat,
            'created_at' => (string) $query->created_at
        ];
    }
}