<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class StoreService
{
    /**
     * Get the ID of the store owner for the current authenticated user.
     * 
     * If user is Admin/SuperAdmin -> Returns their own ID.
     * If user is Cashier -> Returns their creator's ID (the store owner).
     * 
     * @return int|null
     */
    public static function getStoreOwnerId()
    {
        $user = Auth::user();
        if (!$user) return null;

        // If user is a cashier (or any role managed by someone else), return creator's ID
        if ($user->role === 'cashier' || $user->role === 'user') { // Assuming 'user' might be a sub-role too
            return $user->created_by;
        }

        // If user is admin/super_admin, they ARE the store owner
        return $user->id;
    }
}
