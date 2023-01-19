<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;
class unLike extends Model
{
    use HasFactory;
    protected $collection = 'unlikes';
    protected $connection = 'mongodb';

    protected $fillable = [
        'user_id',
        'post_id',

    ];
    public function post(){
        return $this->belongsTo(Post::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}