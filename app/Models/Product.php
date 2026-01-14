<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'user_id',
        'description',
        'cover',
        'price',
        'category_id'
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
            $builder->where('category_id',$value);
        });
    }

    public function getCoverUrlAttribute()
    {
        return env('APP_IMAGES_URL').$this->cover;
    }

}
