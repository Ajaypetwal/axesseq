<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;
class Certificate extends Model
{
    use HasFactory;
    protected $collection = 'certificates';
    protected $connection = 'mongodb';
   
    protected $fillable = [
        'user_id',
        'certificate_image',
        'title',
        'company_name',
        'start_date',
        'end_date',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
