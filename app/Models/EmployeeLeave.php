<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class EmployeeLeave extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'start_date',
        'end_date',
        'reason',
        'status',
        'approver_id',
        'leave_id',
    ];

    

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function adminLeave()
    {
        return $this->hasMany(AdminLeave::class, 'leave_id');
    }

}