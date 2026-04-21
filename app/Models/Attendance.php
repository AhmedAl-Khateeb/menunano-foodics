<?php

namespace App\Models;

use App\Traits\AttendanceTrait;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use AttendanceTrait;

    protected $fillable = [
        'user_id',
        'shift_id',
        'attendance_date',
        'check_in',
        'check_out',
        'status',
        'notes',
    ];

    protected $casts = [
        'attendance_date' => 'date',
        'check_in' => 'datetime',
        'check_out' => 'datetime',
    ];
}
