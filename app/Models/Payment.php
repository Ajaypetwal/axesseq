<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $collection = 'payments';
    protected $connection = 'mongodb';

    protected $fillable = [
        'name',
        'email',
        'user_id',
        'customer_id',
        'card_id',
        'token',
        'status',
        'is_Default',
        'cardLastFourDigit',
        'cardBrand',
        'cardName'
    ];
    public function user()
    {  
        return $this->belongsTo(User::class);  
    } 
}
