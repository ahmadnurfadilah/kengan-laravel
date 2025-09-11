<?php

namespace App\Models;

use App\Models\Campaign\Campaign;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'owner_id',
        'twitter_id',
        'name',
        'username',
        'avatar_url',
        'cover_url',
        'bio',
        'website',
        'total_followers',
        'total_following',
        'total_tweets',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function campaigns()
    {
        return $this->hasMany(Campaign::class, 'project_id');
    }
}
