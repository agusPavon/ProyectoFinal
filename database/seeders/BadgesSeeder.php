<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Badge;

class BadgesSeeder extends Seeder
{
    public function run()
    {
        $badges = [
            [
                'name' => 'Bronze Cafetero',
                'icon' => '🥉',
                'required_beans' => 0,
            ],
            [
                'name' => 'Silver Roaster',
                'icon' => '🥈',
                'required_beans' => 200,
            ],
            [
                'name' => 'Golden Brewer',
                'icon' => '🥇',
                'required_beans' => 600,
            ],
            [
                'name' => 'Master Barista',
                'icon' => '🎖',
                'required_beans' => 1200,
            ],
        ];

        foreach ($badges as $badge) {
            Badge::updateOrCreate(
                ['name' => $badge['name']],
                $badge
            );
        }
    }
}