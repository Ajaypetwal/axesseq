<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Push_card extends Model
{
    use HasFactory;
    protected $collection = 'push_card';
    protected $connection = 'mongodb';
   
    protected $fillable = [

        'image',
        'title', 
        'date',
        'description',
    ];
}
