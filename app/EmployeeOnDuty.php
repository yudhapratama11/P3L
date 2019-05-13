<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeOnDuty extends Model
{
    use SoftDeletes;

    protected $table = "employee_onduties";

    protected $fillable = [
        'id_employee','id_transaction'
    ];

    protected $dates = [
        'created_at','updated_at','deleted_at'
    ];
}
