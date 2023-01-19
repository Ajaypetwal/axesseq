<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;
class Promotion extends Model
{
    protected $collection = 'promotions';
    protected $connection = 'mongodb';
    use HasFactory;

    protected $fillable =[
        "role",
        "promotion_title",
        "image",
        "description",
        "start_date",
        "end_date",
        "amount", 
    ];
}
