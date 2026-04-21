<?php

namespace App\Traits;

use App\Models\BusinessType;
use App\Models\PackageFeature;
use App\Models\packagePermission;
use App\Models\Subscription;
use App\Models\User;

trait PackageTrait
{
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function features()
    {
        return $this->hasMany(PackageFeature::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function businessType()
    {
        return $this->belongsTo(BusinessType::class);
    }

     public function permissions()
    {
        return $this->hasMany(packagePermission::class);
    }

    
}
