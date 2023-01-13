<?php

namespace App\Models;

class Group extends BaseModel
{
    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function setDiscountAttribute($value)
    {
        $this->attributes['discount'] = get_decimal($value, 2);
    }
}
