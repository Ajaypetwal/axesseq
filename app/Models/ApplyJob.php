<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class ApplyJob extends Model
{ 
    protected $collection = 'apply_jobs';
    protected $connection = 'mongodb';
    use HasFactory;

    protected $fillable =[
        "user_id", 
        "job_id",
        "is_checked",      
        "upload_resume",      
        "cover_letter"      
    ];
}
