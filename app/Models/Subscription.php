<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Models\User;
use App\Models\User_Subscription;

class Subscription extends Model
{
    use HasFactory;
    protected $collection = 'Subscription';
    protected $connection = 'mongodb';

    protected $fillable = [
       
        'title',
        'type',
        'descriptions_points',
        'price',
        'plan_type', 
    ];
    public function isSubscribe(){
        return $this->hasOne(User_Subscription::class);
    }
    public function user_subscription(){
        return $this->belongsTo(User_Subscription::class);
    }
}
