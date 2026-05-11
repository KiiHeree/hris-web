<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeSalaryComponent extends Model
{
    use HasFactory;
    protected $fillable = [
        'employee_id',
        'salary_component_id',
        'value'
    ];

    public function salaryComponent() {
        return $this->belongsTo(SalaryComponent::class);
    }
}
