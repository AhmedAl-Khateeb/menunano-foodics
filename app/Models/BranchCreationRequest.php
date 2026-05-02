<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BranchCreationRequest extends Model
{
    protected $table = 'branch_creation_requests';

    protected $fillable = [
        'business_id',
        'requested_by',
        'branch_name',
        'branch_code',
        'phone',
        'address',
        'status',
        'approved_by',
        'approved_at',
        'created_branch_id',
    ];

    public function requester()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function business()
    {
        return $this->belongsTo(User::class);
    }

    public function createdBranch()
    {
        return $this->belongsTo(Branch::class, 'created_branch_id');
    }
}
