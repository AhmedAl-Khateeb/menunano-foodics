<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value','user_id'];

    public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}

    public function scopeLogo($query)
    {
        $logo = $query->where('key','logo')->firstOrFail()->value;
        return env('APP_URL') .'/images/'. $logo;
    }

    public function scopeName($query)
    {
        $name = $query->where('key','Menu Name')->firstOrFail()->value('value');
        return $name;
    }
    public function getValueUrlAttribute()
{
    if ($this->value && file_exists(storage_path('app/public/'.$this->value))) {
        return asset('storage/app/public/'.$this->value);
    }
    return $this->value; // fallback في حالة نص أو لينك خارجي
}

}
