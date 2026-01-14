<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable = [
        'title', 'content', 'image',
    ];
    
    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        if ($this->image) {
            // هنا نخليها ترجع بالرابط اللي إنت عايزه
            return url('storage/app/public/' . $this->image);
        }
        return null;
    }
}
