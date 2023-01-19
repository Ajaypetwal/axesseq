<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;
class Profanity extends Model
{
    use HasFactory;
    protected $collection = 'profanities';
    protected $connection = 'mongodb';
    protected $fillable =[
        "profanity",
        "title_btn",
        
    ];
}
