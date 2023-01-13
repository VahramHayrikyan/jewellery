<?php

namespace App\Http\Resources\Category;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryCollection extends ResourceCollection
{
    public function toArray($request)
    {
        $categories = [];

        foreach ($this->collection as $category) {

            array_push($categories, [
                'data' => ['id' => $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                    'expanded' => false,
                ],

                'children' => new CategoryCollection($category->children)
            ]);

        }

        return $categories;
    }
}
