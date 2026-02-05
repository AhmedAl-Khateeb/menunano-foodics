<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    const TYPE_MENU = 'menu';
    const TYPE_INTERNAL = 'internal';

    protected $fillable = ['name', 'image_url', 'is_active', 'store_id', 'type'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getCoverUrlAttribute()
    {
        return env('APP_IMAGES_URL') . $this->cover;
    }
}
