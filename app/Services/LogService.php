<?php

namespace App\Services;

use App\Models\CartProduct;
use App\Models\Log;
use Exception;

Class LogService extends BaseService
{
    public function store($oldData, $newData)
    {
        Log::create([
            'admin_id' => auth()->user()->id,
            'old_data' => json_encode($oldData),
            'new_data' => json_encode($newData),
        ]);
    }
}
