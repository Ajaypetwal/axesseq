<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class CreateEvent extends Model
{
    protected $collection = 'user_create_events';
    protected $connection = 'mongodb';
    use HasFactory;

    protected $fillable =[
        "role",
        "user_id",
        "event_title",
        "company_logo",
        "job_description",
        "attendees",
        "date",
        "address", 
        "is_hide" 
    ];

   
}
