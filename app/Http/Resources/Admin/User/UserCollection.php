<?php

namespace App\Http\Resources\Admin\User;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    public function toArray($request)
    {
        $users = [];

        foreach ($this->collection as $user) {

            array_push($users, [
                "id" => $user->id,
                "name" => $user->name,
                "email" => $user->email,
                "phone" => $user->phone,
                "group_id" => $user->group,
                "website" => $user->website,
                "comment" => $user->comment,
                "email_verified" => $user->email_verified_at ? 1 : 0,
                "approved" => $user->approved,
            ]);

        }

        return $users;
    }
}
