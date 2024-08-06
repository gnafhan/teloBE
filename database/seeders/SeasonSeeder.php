<?php

namespace Database\Seeders;

use App\Models\Season;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SeasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Season::create([
            'title' => 'Summer 2021',
            'city' => 'Toronto',
            'province' => 'Ontario',
            'description' => 'The summer of 2021 in Toronto, Ontario was a hot one!',
        ]);

        Season::create([
            'title' => 'Winter 2021',
            'city' => 'Toronto',
            'province' => 'Ontario',
            'description' => 'The winter of 2021 in Toronto, Ontario was a cold one!',
        ]);
    }
}
