<?php

namespace App\Models;

use App\Traits\EmployeeTrait;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use EmployeeTrait;

    protected $fillable = ['nip', 'gender', 'address', 'religion'];
}
