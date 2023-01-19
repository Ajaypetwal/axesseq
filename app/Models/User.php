<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Foundation\Auth\User as Authenticatable;
use Jenssegers\Mongodb\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use App\Models\Story;
use App\Models\Setting;
use App\Models\User\CreateJobs;
//use App\Models\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\Sanctum;

class User extends Eloquent
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $collection = 'users';
    protected $connection = 'mongodb';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 
        'email',
        'password',
        'country_code',
        'phone_number',
        'role','otp',
        'image',
        'cover_photo',
        'provider',
        'uid',
        'about_me',
        'link_your_resume',
        'profile_completion',
        'status',
        'device_token'
       
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = ['skill'];

    public function stories()
    {  
        return $this->hasMany(Story::class);
    }    
    public function posts()
    {  
        return $this->hasMany(Post::class);
    }  

    public function likes()
    {  
        return $this->hasMany(Like::class);
    } 

    public function hide_posts()
    {  
        return $this->hasMany(Hide_Post::class);
    } 
    
    public function work_info()
    {  
        return $this->hasMany(WorkInfo::class);
    }
   
    public function certificates()
    {  
        return $this->hasMany(Certificate::class);
    }
    public function calender()
    {  
        return $this->hasMany(Calender::class);
    }

    public function jobs()
    {   
        return $this->hasMany(CreateJobs::class);
    } 
    public function userinfo()
    {  
        return $this->hasOne(UserInfo::class);
    } 
    public function companyinfo()
    {  
        return $this->hasOne(Company_Info::class);
    } 
    public function support()
    {
        return $this->hasMany(Support::class);
    }
    public function privacy_setting()
    {
        return $this->hasOne(Setting::class);
    }
    public function follower()
    {
        return $this->hasMany(Follow::class);
    }
    public function profileSubscription(){
        return $this->hasOne(User_Subscription::class);
    }
    public function userCards(){
        return $this->hasMany(Payment::class)->orderBy('is_Default','true');
    }
    public function pushNotifications(){
        return $this->hasMany(pushNotification::class);
    }

    public function user_subscription(){
        return $this->hasMany(User_Subscription::class);
    }
   
    public function getSkillAttribute(){
        $skill = $this->work_info->last();
        if($skill){
            return $skill['your_role'];
        }
        else{
            return null;
        }
        
    }
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
