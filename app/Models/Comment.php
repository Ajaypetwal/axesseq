<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;
class Comment extends Model
{
    use HasFactory;
    protected $collection = 'comments';
    protected $connection = 'mongodb';

    protected $fillable = [
        'user_id',
        'comment',
        'post_id',
        'image',
        'name'

    ];

    public function post(){
        return $this->hasMany(Post::class);
    }   
   
}
