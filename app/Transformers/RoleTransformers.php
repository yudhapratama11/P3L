<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Role;

class RoleTransformers extends TransformerAbstract
{
    
    public function transform(Role $role)
    {
        return [
            'id'                => $role->id,
            'nama'              => $role->nama,
        ];
    }
}