<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends BaseModel
{
    use SoftDeletes;

    protected $fillable = ['status'];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }
}
