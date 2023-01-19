<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class Messages extends Model
{
    protected $collection = 'messages';
    protected $connection = 'mongodb';
    use HasFactory;

    protected $fillable =[
        
        "user_id",
        "interviewUserID",
        "startTime",
        "endTime",
        "date",
        "note",
        "timezone"
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    
}
