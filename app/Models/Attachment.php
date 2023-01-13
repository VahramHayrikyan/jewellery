<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Attachment extends BaseModel
{
    protected $hidden = ['name', 'attachable_type', 'attachable_id', 'created_at', 'updated_at'];

    protected $guarded = [];

    public function attachable(): MorphTo
    {
        return $this->morphTo();
    }
}
