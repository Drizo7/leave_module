<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;
use App\Models\AdminLeave;
use App\Models\User;

class Leaf extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employee_id',
        'type',
        'start_date',
        'end_date',
        'reason',
        'status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Get the employee associated with the leave.
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Get the admin leave associated with the leave.
     */
    public function adminLeave()
    {
        return $this->hasOne(AdminLeave::class);
    }

    /**
     * Get the approver associated with the leave.
     */
    public function approver()
    {
        return $this->belongsTo(User::class, 'approver_id');
    }
}
