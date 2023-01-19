<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Follow extends Model
{
    protected $collection = 'follows';
    protected $connection = 'mongodb';
    use HasFactory;

    protected $fillable =[
        "user_id",
        "follower_id",
       
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
}
