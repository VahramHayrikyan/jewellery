<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Log extends BaseModel
{
    use HasFactory;

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    public function setAdminAttribute(): BelongsTo
    {
        return $this->attributes['admin'] = $this->admin;
    }

    protected $guarded = [];
}
