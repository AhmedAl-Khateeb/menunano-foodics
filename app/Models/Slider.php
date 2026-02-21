<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image',
        'user_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getImageUrlAttribute()
    {
        if ($this->image && file_exists(storage_path('app/public/sliders/' . $this->image))) {
            return asset('storage/sliders/' . $this->image);
        }
        return asset('images/' . $this->image);
    }
}
