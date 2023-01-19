<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;
    protected $collection = 'faq';
    protected $connection = 'mongodb';
    protected $fillable = [
        'title',
        'description',
        'created_at',
        'updated_at'
    ]; 
}
