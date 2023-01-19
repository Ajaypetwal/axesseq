<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class Job extends Model
{
    protected $collection = 'jobs';
    protected $connection = 'mongodb';
    use HasFactory;

    protected $fillable =[
        "role",
        "user_id",
        "job_title",
        "company_name",
        "company_logo",
        "job_type",
        "salary_range",
        "salary_period",
        "address",
        "job_description",
        "qualification",
        "is_hide" 
    ];
}
