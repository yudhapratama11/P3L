<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\User;
use App\Employees;
use App\Role;
//use App\Branch;


class UserTransformers extends TransformerAbstract
{
    public function transform(User $user)
    {
        return [
            'id'        => $user->id,
            'username'  => $user->username,
            'nama'      => optional($user->employees)->nama,
            'role'      => optional(optional($user->employees)->role)->nama,
            'branch'    => optional(optional($user->employees)->branch)->nama,
        ];
    }
}