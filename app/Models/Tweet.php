<?php

namespace App\Models;

use App\Models\Campaign\Campaign;
use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    protected $fillable = [
        'user_id',
        'campaign_id',
        'tweet_id',
        'text',
        'sentiment',
        'total_view',
        'total_like',
        'total_retweet',
        'total_reply',
        'total_quote',
        'points',
        'sentiment_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}
