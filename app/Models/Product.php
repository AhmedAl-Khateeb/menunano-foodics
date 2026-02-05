<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    const TYPE_READY = 'ready';
    const TYPE_MANUFACTURED = 'manufactured';
    const TYPE_COMPONENT = 'component';

    protected $fillable = [
        'name',
        'description',
        'price',
        'image_url',
        'is_active',
        'store_id',
        'category_id',
        'type'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function sizes()
    {
        return $this->hasMany(ProductSize::class);
    }

    public function user()
    {
       return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeCategoryFilter(Builder $builder)
    {
        $category_id = request()->query('category') ?? null;
        $builder->when($category_id,function ($builder,$value){
            $builder->whereHas('categories', function($q) use ($value) {
                $q->where('categories.id', $value);
            });
        });
    }

    public function getCoverUrlAttribute()
    {
        return env('APP_IMAGES_URL').$this->cover;
    }

}
