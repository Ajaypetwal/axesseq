<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Models\Subscription;
class User_Subscription extends Model
{
    use HasFactory;
    protected $collection = 'user__subscriptions';
    protected $connection = 'mongodb';

    protected $fillable = [
        'user_id',
        'subscription_id',
        'card_id',
        'status',
        'is_subscribed' ,
        'stipeSubscriptionID'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function subscription(){
        return $this->belongsTo(Subscription::class);
    }
}
