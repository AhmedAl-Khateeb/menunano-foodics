<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class packagePermission extends Model
{
    protected $table = 'package_permissions';

    protected $fillable = [
        'package_id',
        'permission_key',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
