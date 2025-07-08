<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserFollow extends Model
{
    
    protected $fillable = [
        'user_following',
        'user_followed',
    ];

    public function userFollowing()
    {
        return $this->belongsTo(User::class, 'user_following');
    }

    public function userFollowed()
    {
        return $this->belongsTo(User::class, 'user_followed');
    }
}
