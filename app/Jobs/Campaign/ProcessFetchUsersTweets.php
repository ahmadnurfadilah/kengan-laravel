<?php

namespace App\Jobs\Campaign;

use App\Http\Integrations\TwitterAPI\Requests\GetAdvancedSearchRequest;
use App\Http\Integrations\TwitterAPI\TwitterAPI;
use App\Models\Campaign\Campaign;
use App\Models\Campaign\CampaignUser;
use App\Models\Tweet;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ProcessFetchUsersTweets implements ShouldQueue
{
    use Queueable;

    public User $user;
    public Campaign $campaign;

    /**
     * Create a new job instance.
     */
    public function __construct(User $user, Campaign $campaign)
    {
        $this->user = $user;
        $this->campaign = $campaign;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $user = $this->user;
        $campaign = $this->campaign;

        $cursor = '';
        $hasNextPage = true;

        $mentions = '';
        $keywords = '';
        $hashtags = '';

        foreach (($campaign->required_mentions ?? []) as $mention) {
            $mentions .= ' @' . $mention;
        }
        foreach (($campaign->required_keywords ?? []) as $keyword) {
            $keywords .= ' ' . $keyword;
        }
        foreach (($campaign->required_hashtags ?? []) as $hashtag) {
            $hashtags .= ' #' . $hashtag;
        }

        $q = $mentions . " " . $keywords . " " . $hashtags . " from:" . $user->username . " since:" . Carbon::parse($campaign->started_at)->format('Y-m-d_H:i:s_') . 'UTC';

        $twitter = new TwitterAPI;
        while ($hasNextPage) {
            $response = $twitter->send(new GetAdvancedSearchRequest($q, $cursor));
            $data = $response->json();
            foreach ($data['tweets'] as $tweet) {
                $points =   ($tweet['viewCount'] * 0.1) +
                            ($tweet['likeCount'] * 1.5) +
                            ($tweet['retweetCount'] * 2) +
                            ($tweet['replyCount'] * 2) +
                            ($tweet['quoteCount'] * 2);

                Tweet::updateOrCreate(
                    [
                        'tweet_id' => $tweet['id']
                    ],
                    [
                        'user_id' => $user->id,
                        'campaign_id' => $campaign->id,
                        'tweet_id' => $tweet['id'],
                        'text' => $tweet['text'],
                        'total_view' => $tweet['viewCount'],
                        'total_like' => $tweet['likeCount'],
                        'total_retweet' => $tweet['retweetCount'],
                        'total_reply' => $tweet['replyCount'],
                        'total_quote' => $tweet['quoteCount'],
                        'points' => $points,
                        'created_at' => Carbon::parse($tweet['createdAt'])->format('Y-m-d H:i:s'),
                    ]
                );
            }

            $cursor = $data['next_cursor'];
            $hasNextPage = $data['has_next_page'];
        }

        $totalPoints = Tweet::where('user_id', $user->id)
            ->where('campaign_id', $campaign->id)
            ->sum('points');

        CampaignUser::updateOrCreate([
            'campaign_id' => $campaign->id,
            'user_id' => $user->id,
        ], [
            'points' => $totalPoints,
        ]);
    }
}
