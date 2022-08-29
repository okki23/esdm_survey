<?php
namespace App\Transformer;

use League\Fractal\TransformerAbstract;
use App\Models\Category;

class CategoryTransformer extends TransformerAbstract
{
    public function transform(Category $query)
    {
        return [
            'id' => (int) $query->id,
            'category_name' => (string) $query->category_name,
            'status' => (string) $query->status
        ];
    }
}