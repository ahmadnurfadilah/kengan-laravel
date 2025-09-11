<?php

namespace App\Models\Project;

use App\Models\Campaign\Campaign;
use App\Models\User;
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
        'discord',
        'type_id',
        'category_id',
        'total_followers',
        'total_following',
        'total_tweets',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function type()
    {
        return $this->belongsTo(ProjectType::class, 'type_id');
    }

    public function category()
    {
        return $this->belongsTo(ProjectCategory::class, 'category_id');
    }

    public function campaigns()
    {
        return $this->hasMany(Campaign::class, 'project_id');
    }
}
