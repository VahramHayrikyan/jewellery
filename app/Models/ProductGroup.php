<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductGroup extends BaseModel
{
    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->hidden = array_merge($this->hidden, ['created_at', 'updated_at', 'product_id']);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function setAttributeProduct(): BelongsTo
    {
        return $this->attributes['product'] = $this->product;
    }
}
