<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Support_Message extends Model
{ 
    use HasFactory;
    protected $collection = 'support__messages';
    protected $connection = 'mongodb';

    protected $fillable = [
        'user_id',
        'support_id',
        'message', 
        'upload_pic_video',
        'is_type'
    ];
    public function user()
    {  
        return $this->belongsTo(User::class);  
    } 
    public function support()
    {  
        return $this->belongsTo(Support::class);  
    } 

}
