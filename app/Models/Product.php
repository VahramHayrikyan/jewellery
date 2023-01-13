<?php

namespace App\Models;

use App\Services\ProductService;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends BaseModel
{
    use SoftDeletes;

    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->hidden = array_merge($this->hidden, ['created_at', 'updated_at', 'pivot']);
    }

    //-------------------- - - relationships - - -----------------------
    public function carts(): BelongsToMany
    {
        return $this->belongsToMany(Cart::class);
    }

    public function attachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function firstAttachment(): MorphOne
    {
        return $this->morphOne(Attachment::class, 'attachable')->latest();
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class)->withPivot(['category_id']);
    }

    public function productGroups(): HasMany
    {
        return $this->hasMany(ProductGroup::class);
    }

    public function attributeValues(): BelongsToMany
    {
        return $this->belongsToMany(AttributeValue::class)->withPivot(['id', 'price']);
    }
    //-------------------- - - /relationships - - -----------------------

    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = get_decimal($value, 2);
    }

    public function setDiscountAttribute($value)
    {
        $this->attributes['discount'] = !$value ? 0.00 : $value;
    }

    public function scopeFilter($query, $request)
    {
        if ($request->key) {
            $query->where(function ($q) use ($request) {
                return $q->where('name', 'like', "%$request->key%")
                    ->orWhere('description', 'like', "%$request->key%")
                    ->orWhere('code', 'like', "%$request->key%");
            });
        }
        if ($request->price_from) {
            if (!$request->user()->group_id) {
                $query->where('price', '>=', $request->price_from);
            } else {
                $query->where('price', '>=', get_price_from_discounted($request->price_from, $request->user()->group->discount));
            }
        }
        if ($request->price_to) {
            if (!$request->user()->group_id) {
                $query->where('price', '<=', $request->price_to);
            } else {
                $query->where('price', '<=', get_price_from_discounted($request->price_to, $request->user()->group->discount));
            }
        }
        if ($request->category) {
            $subcategoryIds = (new ProductService())->getSubcategoryIds($request->category);
            array_push($subcategoryIds, (int)$request->category);

            $query->whereHas('categories', function ($q) use ($request, $subcategoryIds) {
                return $q->whereIn('category_id', $subcategoryIds);
            });
        }

        return $query;
    }
}
