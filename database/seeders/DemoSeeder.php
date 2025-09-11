<?php

namespace Database\Seeders;

use App\Http\Integrations\TwitterAPI\Requests\GetUserInfoRequest;
use App\Http\Integrations\TwitterAPI\TwitterAPI;
use App\Models\Campaign\Campaign;
use App\Models\Project\Project;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $owner = User::where('email', 'ahmadnurfadilah22@gmail.com')->first();

        $campaigns = [
            [
                'twitter_handle' => 'Khugaverse',
                'title' => 'Khuga Campaign S1',
                'description' => 'The Khugaverse Ecosystem powered by $KOIN launching on @AbstractChain',
                'required_mentions' => ['Khugaverse'],
                'required_keywords' => ['Khugaverse'],
                'required_hashtags' => null,
                'reward_amount' => 50,
                'reward_currency' => 'USD',
                'topic_objective' => 'The Khugaverse Ecosystem powered by $KOIN launching on @AbstractChain',
                'started_at' => '2025-08-01 00:00:00',
                'ended_at' => '2025-09-30 23:59:59',
                'users' => [
                    'ariksskn',
                    'NoxescanorGOH',
                    'ZenkiQQ',
                    'Neslie_eth',
                    'dongcobadulu',
                    'sven26xs',
                    'Virchow24',
                    'Apexkid04',
                    'Web3aang',
                    'Uviolet_01',
                    'crisscross109',
                    'rubion1zq',
                    'GustavoOnChain',
                    'trendkoinim',
                    'Big_Daveee1',
                    'ChainOnMike',
                    'KingJACeth',
                    '0xsinnabon',
                    'Vikt96r',
                    'infrared2406',
                ],
            ],
            [
                'twitter_handle' => 'chogstarrr',
                'title' => 'Chogstarrr Campaign S1',
                'description' => 'This the sample of Chogstarrr Campaign',
                'required_mentions' => ['chogstarrr'],
                'required_keywords' => null,
                'required_hashtags' => null,
                'reward_amount' => 100,
                'reward_currency' => 'USD',
                'topic_objective' => 'This the sample of Chogstarrr Campaign',
                'started_at' => '2025-06-10 00:00:00',
                'ended_at' => '2025-09-30 23:59:59',
                'users' => [
                    'wyckoffweb',
                    '0xtequilaa',
                    '827894142Guxin',
                    'NftTcollector',
                    'ngjbt1',
                    'huahua3843',
                    'Danny250018',
                    'Monad_Daily',
                    '_kun09_',
                    'kodaklolly',
                    'bao21083154',
                    'ZinHanari',
                ],
            ],
            [
                'twitter_handle' => 'KaiaChain',
                'title' => 'KaiaChain Campaign S1',
                'description' => 'This the sample of KaiaChain Campaign',
                'required_mentions' => ['KaiaChain'],
                'required_keywords' => null,
                'required_hashtags' => null,
                'reward_amount' => 100,
                'reward_currency' => 'USD',
                'topic_objective' => 'This the sample of KaiaChain Campaign',
                'started_at' => '2025-09-01 00:00:00',
                'ended_at' => '2025-09-30 23:59:59',
                'users' => [
                    'pukerrainbrow',
                    'pet3rpan_',
                    'museowunsaram',
                    'AirdropKor_eth',
                    'bug4what',
                    'MOODOO_Diary',
                    'DaanCrypto',
                    'xiaoyubtc',
                    '0x_Todd',
                    'periagoge1'
                ],
            ]
        ];

        foreach ($campaigns as $campaign) {
            $twitterAPI = new TwitterAPI;
            $response = $twitterAPI->send(new GetUserInfoRequest($campaign['twitter_handle']));
            $json = $response->json();
            $data = $json['data'];

            $project = Project::firstOrNew(['twitter_id' => $data['id'], 'owner_id' => $owner->id]);
            $project->name = $data['name'];
            $project->username = $campaign['twitter_handle'];
            $project->avatar_url = $data['profilePicture'];
            $project->cover_url = $data['coverPicture'];
            $project->bio = $data['description'];
            $project->website = $data['url'];
            $project->total_followers = $data['followers'];
            $project->total_following = $data['following'];
            $project->total_tweets = $data['statusesCount'];
            $project->save();

            $c = Campaign::firstOrNew(['project_id' => $project->id, 'owner_id' => $owner->id]);
            $c->status = 'active';
            $c->title = $campaign['title'];
            $c->slug = Str::slug($campaign['title']);
            $c->description = $campaign['description'];
            $c->required_mentions = $campaign['required_mentions'];
            $c->required_keywords = $campaign['required_keywords'];
            $c->required_hashtags = $campaign['required_hashtags'];
            $c->reward_amount = $campaign['reward_amount'];
            $c->reward_currency = $campaign['reward_currency'];
            $c->topic_objective = $campaign['topic_objective'];
            $c->website = $campaign['website'] ?? ($project->website);
            $c->avatar_url = $data['profilePicture'];
            $c->cover_url = $data['coverPicture'];
            $c->started_at = $campaign['started_at'];
            $c->ended_at = $campaign['ended_at'];
            $c->save();

            foreach ($campaign['users'] as $user) {
                $twitterAPI = new TwitterAPI;
                $response = $twitterAPI->send(new GetUserInfoRequest($user));
                $json = $response->json();
                $data = $json['data'];

                if (isset($data['id'])) {
                    $u = User::firstOrNew(['twitter_id' => $data['id']]);
                    $u->name = $data['name'];
                    if (!$u->email) {
                        $u->email = $user . '@example.com';
                        $u->username = $user;
                    }
                    $u->password = Hash::make('password');
                    $u->avatar_url = $data['profilePicture'];
                    $u->save();

                    $c->users()->sync([$u->id], false);
                } else {
                    Log::debug('User ' . $user . ' not found');
                    continue;
                }
            }
        }
    }
}
