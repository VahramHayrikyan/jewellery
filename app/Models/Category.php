<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends BaseModel
{
    use SoftDeletes;

    protected $guarded = [];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id')->select('id', 'parent_id', 'name', 'slug');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id')->select('id', 'parent_id', 'name', 'slug');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

}
