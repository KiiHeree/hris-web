<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'period',
        'salary_basic',
        'total_allowance',
        'total_deduction',
        'net_salary',
        'status'
    ];

    public function items()
    {
        return $this->hasMany(PayrollItem::class);
    }

    public function employee() {
        return $this->belongsTo(Employees::class,'employee_id','id');
    }

}
