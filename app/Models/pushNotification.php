<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Models\User;
class pushNotification extends Model
{
    use HasFactory;
    protected $collection = 'push_notifications';
    protected $connection = 'mongodb';

    protected $fillable = [
        'user_id',
        'type',
        'title',
        'description',
        'viewedUserId' 
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
