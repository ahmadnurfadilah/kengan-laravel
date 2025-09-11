<?php

namespace App\Console\Commands;

use App\Jobs\Campaign\ProcessFetchUsersTweets;
use App\Models\Campaign\Campaign;
use App\Models\Campaign\CampaignUser;
use Illuminate\Console\Command;

class CampaignFetchUsersTweets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:campaign:fetch-users-tweets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch users tweets';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $programs = Campaign::active()->whereDate('started_at', '<=', now())->whereDate('ended_at', '>=', now())->get();
        foreach ($programs as $program) {
            foreach ($program->users as $user) {
                ProcessFetchUsersTweets::dispatch($user, $program);
            }

            // Update rank
            $programUsers = CampaignUser::where('campaign_id', $program->id)->orderBy('points', 'desc')->get();
            foreach ($programUsers as $index => $programUser) {
                $programUser->rank = $index + 1;
                $programUser->save();
            }
        }
    }
}
