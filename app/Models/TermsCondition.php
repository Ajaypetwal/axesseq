<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class TermsCondition extends Model
{
    public $timestamps = FALSE;
    use HasFactory;
    protected $collection = 'terms_conditions';
    protected $connection = 'mongodb';
    protected $fillable = [
        'term_condition',
        'description',
        'created_at',
        'updated_at'
       
    ]; 
   

}
