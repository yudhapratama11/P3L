<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\User;
use App\Employees;
//use App\Role;
//use App\Branch;


class UserTransformers extends TransformerAbstract
{
    public function transform(User $user)
    {
        return [
            'id'        => $user->id,
            'username'  => $user->username,
            'name'      => optional($user->employee)->nama,
            //'role'      => optional(optional($user->employee)->roles)->nama,
            //'branch'    => optional(optional($user->employee)->branch)->name_branch,
        ];
    }
}