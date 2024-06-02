<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\User;

class UserTransFormer extends TransformerAbstract
{
    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'uname' => $user->uname,
            'email' => $user->email
        ];
    }
}
