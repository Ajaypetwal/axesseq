<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;
class Login extends Model
{
    use HasFactory;
  
    protected $connection = 'mongodb';
    use HasFactory;
    
    protected $fillable = [
        
    ];
}
