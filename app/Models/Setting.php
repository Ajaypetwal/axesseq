<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Models\User;

class Setting extends Model
{
    use HasFactory;
    protected $collection = 'settings';
    protected $connection = 'mongodb';

    protected $fillable = [
        'user_id',
        'name',
        'address',
        'started_date',
        'email_address',
        'phone_number',
        'about_me',
        'work_experience',
        'certificates'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
}
