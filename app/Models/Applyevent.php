<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class Applyevent extends Model
{
    protected $collection = 'applyevents';
    protected $connection = 'mongodb';
    use HasFactory;

    protected $fillable =[
        "user_id", 
        "event_id" 
       
    ];
}
