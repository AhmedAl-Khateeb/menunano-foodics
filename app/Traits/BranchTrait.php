<?php

namespace App\Traits;

use App\Models\User;

trait BranchTrait
{
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
