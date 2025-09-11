<?php

namespace App\Console\Commands;

use App\Models\Tweet;
use Illuminate\Console\Command;

class AnalyzeTweetSentiment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:analyze-tweet-sentiment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Analyze the sentiment of a tweet';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tweets = Tweet::whereNull('sentiment')->whereNull('sentiment_at')->inRandomOrder()->take(1000)->get();

        foreach ($tweets as $tweet) {
            try {
                $sentiment = $this->getSentiment($tweet->text);

                if ($sentiment) {
                    $tweet->sentiment = $sentiment;
                    $tweet->sentiment_at = now();
                    $tweet->save();
                }

                $this->info('Analyzed tweet: ' . $tweet->id . ' with sentiment: ' . $sentiment);
            } catch (\Throwable $th) {
                $this->error('Error analyzing tweet: ' . $th->getMessage());
                continue;
            }
        }
    }

    protected function getSentiment(string $text)
    {
        $client = new \GuzzleHttp\Client();

        // "model": "deepseek/deepseek-chat-v3-0324:free",
        $response = $client->request('POST', 'https://openrouter.ai/api/v1/chat/completions', [
            'body' => '{
                "model": "openai/gpt-4o-mini",
                "messages": [
                    {
                        "role": "system",
                        "content": "You are a sentiment analysis expert. You will be given a tweet and you will need to analyze the sentiment of the tweet. The sentiment is score from 0 to 100 (0 is the most negative and 100 is the most positive). Only return the sentiment score, no other text or explanation."
                    },
                    {
                        "role": "user",
                        "content": "' . $text . '"
                    }
                ]
            }',
            'headers' => [
                'Authorization' => 'Bearer ' . config('services.openrouter.key'),
                'Content-Type' => 'application/json',
            ],
        ]);

        $data = json_decode($response->getBody()->getContents(), true);

        return $data['choices'][0]['message']['content'] ?? 'neutral';
    }
}
