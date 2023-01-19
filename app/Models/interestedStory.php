<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class interestedStory extends Model
{
    use HasFactory;
    protected $collection = 'interested_stories';
    protected $connection = 'mongodb';

    protected $fillable = [
        'user_id',
        'story_id',
        'story_user_id'

    ];
}
