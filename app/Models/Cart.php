<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends BaseModel
{
    use SoftDeletes;

    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->hidden = array_merge($this->hidden, ['pivot']);
    }

    //-------------------- - - relationships - - -----------------------
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->withPivot('id', 'quantity', 'unit_price', 'comment');
    }

    public function order(): HasOne
    {
        return $this->hasOne(Order::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    //-------------------- - - /relationships - - -----------------------

    //-------------------- - - local scopes - - -----------------------
    public function scopeUserCarts($query)
    {
        return $query->where('user_id', auth()->user()->id);
    }
    //-------------------- - - /local scopes - - -----------------------
}
