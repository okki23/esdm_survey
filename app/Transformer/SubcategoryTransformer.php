<?php
namespace App\Transformer;

use League\Fractal\TransformerAbstract;
use App\Models\Subcategory;

class SubcategoryTransformer extends TransformerAbstract
{
    public function transform(Subcategory $query)
    {
        return [
            'id' => (int) $query->id,
            'category_id' => (int) $query->category_id,
            'category_name' => (string) $query->subcategory_name,
            'status' => (string) $query->status,
            'category' => (object) $query->category
        ];
    }
}