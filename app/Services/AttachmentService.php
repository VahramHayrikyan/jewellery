<?php

namespace App\Services;

use App\Models\Product;
use Exception;
use Illuminate\Support\Str;

Class AttachmentService extends BaseService
{
    public function store($request, $product)
    {
        foreach ($request->images as $image) {
            $fileName = $image->getClientOriginalName();
            $filePath = $image->storeAs('/attachments/products', Str::random(10) . $fileName);
            $product->attachments()->create([
                'name' => $fileName,
                'path' => 'storage/' . $filePath,
            ]);
        }
    }
}
