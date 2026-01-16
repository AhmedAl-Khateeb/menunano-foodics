<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    // protected $casts = [
    //     'user_role' => 'array',
    // ];
    // Cast removed as user_role is now a string
}
