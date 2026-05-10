<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public const TYPE_MENU = 'menu';
    public const TYPE_INTERNAL = 'internal';

    protected $fillable = ['name', 'cover', 'is_active', 'store_id', 'type', 'user_id', 'parent_id'];

    // الفئة الرئيسية للفئة الفرعية
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // الفئات الفرعية التابعة لهذه الفئة
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

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
        if ($this->cover) {
            return asset('storage/categories/'.$this->cover);
        }

        return null;
    }
}
