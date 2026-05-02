<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BranchUser extends Model
{
    protected $fillable = [
        'branch_id',
        'user_id',
        'role',
        'is_primary_manager',
        'can_manage_permissions',
        'permissions',
        'assigned_by',
    ];

    protected $casts = [
        'permissions' => 'array',
        'is_primary_manager' => 'boolean',
        'can_manage_permissions' => 'boolean',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }
}
