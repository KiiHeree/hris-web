<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    use HasFactory;

    protected $fillable = [
        'nik',
        'join_date',
        'department_id',
        'position_id',
        'salary_basic',
        'bank_account',
    ];
}
