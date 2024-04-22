<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminLeave extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'type',
        'start_date',
        'end_date',
        'reason',
        'status',
        'approver_id',
        'leave_id',
    ];
    
    public function employeeLeave()
    {
        return $this->belongsTo(EmployeeLeave::class, 'leave_id');
    }

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approver_id');
    }
}