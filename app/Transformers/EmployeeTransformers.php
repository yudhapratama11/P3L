<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Employees;
use App\Role;
use App\Branch;

class EmployeeTransformers extends TransformerAbstract
{
    
    public function transform(Employees $employee)
    {
        return [
            'id'                => $employee->id,
            'nama'              => $employee->nama,
            'nomor_telepon'     => $employee->nomor_telepon,
            'alamat'            => $employee->alamat,
            'gaji'              => $employee->gaji,
            'role'              => optional($employee->role)->nama,
            'branch'            => optional($employee->branch)->nama,
            'id_roles'          => $employee->id_roles,
            'id_branch'         => $employee->id_branch,  
        ];
    }
}