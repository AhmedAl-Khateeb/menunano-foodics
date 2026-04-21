<?php

namespace App\Traits;

use App\Models\Package;

trait PackageFeatureTrait
{
    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
