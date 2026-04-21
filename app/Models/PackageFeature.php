<?php

namespace App\Models;

use App\Traits\PackageFeatureTrait;
use Illuminate\Database\Eloquent\Model;

class PackageFeature extends Model
{
    use PackageFeatureTrait;

    protected $table = 'package_features';

    protected $fillable = [
        'package_id',
        'text',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
