<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Models\User;
class Story extends Model
{
    protected $collection = 'story';
    protected $connection = 'mongodb';
    use HasFactory;
    protected $fillable = [
        'image',
        'bgcolor',
        'title',
        'description',
        'keywords',
        'user_id'
    ];

    public function user()
    {  
        return $this->belongsTo(User::class);  
    }  
    
}
