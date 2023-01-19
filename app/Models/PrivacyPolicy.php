<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class PrivacyPolicy extends Model
{
    use HasFactory;
    protected $collection = 'privacy_policy';
    protected $connection = 'mongodb';
    protected $fillable =[
        "privay_policy",
         "description",
         "created_at",
         "updated_at"
        
    ];
    
}
