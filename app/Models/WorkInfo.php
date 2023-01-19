<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;
class WorkInfo extends Model
{
    
    protected $collection = 'workinfo';
    protected $connection = 'mongodb';
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'company_name',
        'your_role',
        'your_experience',
        'link_your_resume',
        'about_me',
        'start_date',
        'end_date',
        'image'       
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

}
