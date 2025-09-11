<?php

namespace Database\Seeders;

use App\Models\Project\ProjectCategory;
use App\Models\Project\ProjectType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'type' => 'NFT',
                'categories' => [
                    'PFP (Profile Picture)',
                    'Art',
                    'Gaming',
                    'Collectibles',
                    'Utility',
                    'Music & Media',
                    'Virtual Land & Metaverse',
                    'DeFi & Financial',
                    'Domain Names',
                    'Experimental/Narrative',
                    'Other',
                ],
            ],
            [
                'type' => 'Token',
                'categories' => [
                    'Smart Contract Platforms',
                    'General Purpose Blockchains',
                    'Specialized Layer 1s',
                    'Rollups (Optimistic, ZK)',
                    'Sidechains',
                    'State Channels',
                    'DeFi',
                    'Governance',
                    'Utility',
                    'Security',
                    'Stablecoins',
                    'Payment',
                    'Gaming / Metaverse',
                    'Meme',
                    'Privacy',
                    'Oracle Tokens',
                    'Data & Storage',
                    'Interoperability (Cross-chain, Bridges)',
                    'Staking & Liquid Staking',
                    'Identity & Domain',
                    'Other',
                ],
            ],
        ];

        foreach ($data as $item) {
            $type = ProjectType::firstOrCreate(['name' => $item['type']]);
            foreach ($item['categories'] as $category) {
                ProjectCategory::firstOrCreate(['type_id' => $type->id, 'name' => $category]);
            }
        }
    }
}
