<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;
class Event extends Model
{
    protected $collection = 'events';
    protected $connection = 'mongodb';
    use HasFactory;

    protected $fillable =[
        "role",
        "event_title",
        "company_logo",
        "job_description",
        "attendees",
        "date",
        "address",  
        "user_id"
    ];
    

    public function calender()
    {  
        return $this->hasMany(Calender::class);
    }
    
    
}
