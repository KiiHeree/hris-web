<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nik',
        'join_date',
        'department_id',
        'position_id',
        'salary_basic',
        'bank_account',
        'bank_name',
        'birth_place',
        'birth_date',
        'full_name',
        'telp',
        'manager_id',
        'employment_status_id',
        'employee_code',
        'notes',
        'address',
        'gender',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $prefix = strtoupper(substr($model->full_name, 0, 3));
            $count = static::where('employee_code', 'like', $prefix . '%')->count() + 1;
            $model->employee_code = $prefix . str_pad($count, 4, '0', STR_PAD_LEFT);
        });
    }  

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }

}
