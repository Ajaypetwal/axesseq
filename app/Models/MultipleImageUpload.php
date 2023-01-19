<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;
class MultipleImageUpload extends Model
{
    protected $collection = 'multipleimageupload';
    protected $connection = 'mongodb';
    use HasFactory;
    protected $fillable = [
        'image',
        
    ];
}
