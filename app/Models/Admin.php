<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;
class Admin extends Model
{
    use HasFactory;
    protected $collection = 'admins';
    protected $connection = 'mongodb';
   
    protected $fillable = [

        'username',
        'password', 
    ];

}
