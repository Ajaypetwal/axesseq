<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;
class Hide_Post extends Model
{
    use HasFactory;
    protected $collection = 'hide__posts';
    protected $connection = 'mongodb';
    protected $fillable = [
        'post_id',
        'post_user_id',
        'user_id',
        'single_post',
        'all_post',
    ]; 


    public function user(){
        return $this->belongsTo(User::class);
    }


    
}
