<?php

namespace App\Models\Campaign;

use App\Models\Project;
use App\Models\User;
use App\Models\Tweet;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $fillable = [
        'owner_id',
        'project_id',
        'status',
        'title',
        'slug',
        'description',
        'required_mentions',
        'required_keywords',
        'required_hashtags',
        'reward_amount',
        'reward_currency',
        'topic_objective',
        'website',
        'avatar_url',
        'cover_url',
        'started_at',
        'ended_at',
    ];

    protected $casts = [
        'required_mentions' => 'array',
        'required_keywords' => 'array',
        'required_hashtags' => 'array',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'campaign_user')->withPivot('points')->withTimestamps();
    }

    public function tweets()
    {
        return $this->hasMany(Tweet::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
