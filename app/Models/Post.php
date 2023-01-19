<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use Auth;
use App\Models\User;

class Post extends Model
{
    protected $collection = 'posts';
    protected $connection = 'mongodb';
    protected $appends = array('likes','unLike');
    
    
    protected $fillable = [
        'user_id',
        'description',
        'media',
        'status',
    ];

    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function comment(){
        return $this->hasMany(Comment::class);
    }
    public function like(){
        return $this->hasMany(Like::class);
    }
    public function unlike(){
        return $this->hasMany(unLike::class);
    }

    public function getLikesAttribute(){
        $likes = $this->like;
        if($likes){
            return $this->like->count();
        }
        else{
            return 0;
        }
        
    } 
    public function getunLikeAttribute(){
        $unLike = $this->unLike;
        if($unLike){
            return $this->unLike->count();
        }
        else{
            return 0;
        }
        
    } 
}
