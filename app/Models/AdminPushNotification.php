<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
 // use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;
class AdminPushNotification extends Model
{
    protected $collection = 'admin_push_notifications';
    protected $connection = 'mongodb';
    use HasFactory;
    protected $fillable = [
        'type',
         'date',
        'title',
        // 'toall',
        'history',
        'description',
        'emoji',
        'file',

    ];
}