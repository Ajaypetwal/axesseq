<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Models\Support;

class UserInfo extends Model
{
    protected $collection = 'users_info';
    protected $connection = 'mongodb';
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'company_name',
        'company_email',
        'company_phone',
        'business_address',
        'business_number',
        'about_company',
        'image',
        'website',
        'profile_pic',
        'cover_pic'
        
    ];
    public function user()
    {  
        return $this->belongsTo(User::class);  
    }  
    public function support()
    {
        return $this->hasMany(Support::class);
    }
}
