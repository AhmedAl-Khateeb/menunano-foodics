<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use  App\Models\staff;
use Illuminate\Database\Eloquent\Model;

class salary_m extends Model
{
    // use HasFactory;

    protected $table = 'salary_m';

    protected $fillable = ['staff_id', 'penalties','Salary_advance','Rewards','user_id', 'created_at', 'updated_at', 'created_by'];

    public $timestamps=true;   // default  true or false


    public function staff()
    {
        return $this->belongsTo(staff::class);
    }

}
