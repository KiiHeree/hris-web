<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryComponent extends Model
{
    use HasFactory;
    protected $table = 'salary_components';
    protected $fillable = [
        'name',
        'type',
        'calculation_type',
        'default_value'
    ];
}
