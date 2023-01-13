<?php

namespace App\Http\Resources\Admin\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "email" => $this->email,
            "phone" => $this->phone,
            "group_id" => $this->group,
            "website" => $this->website,
            "comment" => $this->comment,
            "email_verified" => $this->email_verified_at ? 1 : 0,
            "approved" => $this->approved,
        ];
    }
}
