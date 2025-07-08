<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    
    protected $fillable = [
        'owner_id',
        'title',
        'content',
        'estimated_reading_time',
        'likes',
        'description',
        'categorie',
        'tags',
    ];

    public function user() 
    {
        return $this->belongsTo(User::class);
    }

    public function comments() 
    {
        return $this->hasMany(Comment::class);
    }
}
