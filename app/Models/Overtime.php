<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Overtime extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'date',
        'start_time',
        'end_time',
        'total_hours',
        'status',
        'approver_id'
    ];

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }
    public function approver()
    {
        return $this->belongsTo(User::class, 'approver_id');
    }
}
