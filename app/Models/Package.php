<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'duration',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
    
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

}
