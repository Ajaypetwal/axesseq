<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Models\User\CreateEvent;

class Calender extends Model
{
    protected $collection = 'calender';
    protected $connection = 'mongodb';
    use HasFactory;

    protected $fillable =[
        "role", 
        "user_id",
        "event_id"      
    ];
    protected $appends = ['event'];

    
    public function event(){
        return $this->belongsTo(Event::class);
    }
    
    public function getEventAttribute(){
        $event = $this->event;
        if($event){
            return $event;
        }
        else{
            return null;
        }
        
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    
}
