<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BranchLink extends Model
{
    protected $table = 'branch_links';

    protected $fillable = [
        'business_id',
        'from_branch_id',
        'to_branch_id',
        'type',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function fromBranch()
    {
        return $this->belongsTo(Branch::class, 'from_branch_id');
    }

    public function toBranch()
    {
        return $this->belongsTo(Branch::class, 'to_branch_id');
    }

    public function business()
    {
        return $this->belongsTo(User::class);
    }
}
