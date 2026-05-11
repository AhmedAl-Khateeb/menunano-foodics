<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessTypePermissionDefault extends Model
{
    protected $fillable = [
        'business_type_id',
        'permission_key',
        'is_active',
    ];

    public function businessType()
    {
        return $this->belongsTo(BusinessType::class);
    }
}