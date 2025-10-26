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
        'net',
        'status'
    ];

    public function items()
    {
        return $this->hasMany(PayrollItem::class);
    }

}
