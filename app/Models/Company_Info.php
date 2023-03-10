<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class Company_Info extends Model
{
    protected $collection = 'company_info';
    protected $connection = 'mongodb';
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'industry',
        'size_of_company',
        'headquarters',
        'founded'
        
    ];
    public function user()
    {  
        return $this->belongsTo(User::class);  
    }  
}
