<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class staff extends Model
{
    // use HasFactory;

    protected $table = 'staff';

    protected $fillable = ['Name', 'BirthDay', 'Academic_qualification','Start_date', 'End_date','attach_File','Salary','user_id' ,'created_at', 'updated_at', 'created_by'];

    public $timestamps=true;   // default  true or false




}
