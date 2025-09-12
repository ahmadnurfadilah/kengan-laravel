<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use LucasDotVin\Soulbscription\Enums\PeriodicityType;
use LucasDotVin\Soulbscription\Models\Feature;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $featCampaign = Feature::create([
            'consumable'       => true,
            'name'             => 'campaign',
        ]);

        $featCampaignParticipants = Feature::create([
            'consumable'       => true,
            'name'             => 'campaign-participants',
        ]);

        $featCampaignMentions = Feature::create([
            'consumable'       => true,
            'name'             => 'campaign-mentions',
        ]);

        $featCampaignKeywords = Feature::create([
            'consumable'       => true,
            'name'             => 'campaign-keywords',
        ]);

        $basic = Plan::create([
            'name'             => 'basic',
            'periodicity_type' => PeriodicityType::Month,
            'periodicity'      => 1,
            'price'            => 500,
        ]);

        $plus = Plan::create([
            'name'             => 'plus',
            'periodicity_type' => PeriodicityType::Month,
            'periodicity'      => 1,
            'price'            => 1000,
        ]);

        $pro = Plan::create([
            'name'             => 'pro',
            'periodicity_type' => PeriodicityType::Month,
            'periodicity'      => 1,
            'price'            => 2000,
        ]);

        $basic->features()->attach($featCampaign, ['charges' => 1]);
        $basic->features()->attach($featCampaignParticipants, ['charges' => 1000]);
        $basic->features()->attach($featCampaignMentions, ['charges' => 1]);
        $basic->features()->attach($featCampaignKeywords, ['charges' => 1]);

        $plus->features()->attach($featCampaign, ['charges' => 2]);
        $plus->features()->attach($featCampaignParticipants, ['charges' => 2000]);
        $plus->features()->attach($featCampaignMentions, ['charges' => 2]);
        $plus->features()->attach($featCampaignKeywords, ['charges' => 2]);

        $pro->features()->attach($featCampaign, ['charges' => 3]);
        $pro->features()->attach($featCampaignParticipants, ['charges' => 3000]);
        $pro->features()->attach($featCampaignMentions, ['charges' => 3]);
        $pro->features()->attach($featCampaignKeywords, ['charges' => 3]);//
    }
}
