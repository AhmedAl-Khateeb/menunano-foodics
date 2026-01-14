<?php

namespace App\Traits;

use App\Models\User;

trait StoreHelper
{
    public function getUserByStoreName(string $storeName)
    {
        return User::where('store_name', $storeName)->firstOrFail();
    }
}
