<?php

namespace App\Models\Campaign;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CampaignUser extends Pivot
{
    protected $table = 'campaign_user';

    protected $fillable = [
        'campaign_id',
        'user_id',
        'points',
        'rank',
    ];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
