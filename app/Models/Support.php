<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Models\UserInfo;

class Support extends Model
{
    use HasFactory;
    protected $collection = 'supports';
    protected $connection = 'mongodb';

    protected $fillable = [
        'user_id',
        'role',
        'ticket_number',
        'subject',
        'message',
        'serialNumber',
        'upload_pic_video',
        'status'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function support_message()
    {
        return $this->hasMany(Support_Message::class);
    }
    public function userinfo()
    {
        return $this->belongsTo(UserInfo::class);
    }
}
