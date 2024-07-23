<?php

namespace Database\Seeders;

use App\Models\Character;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CharacterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Character::create([
            'name' => 'John Doe',
            'role' => 'Warrior',
            'age' => 30,
            'filepath' => 'images/characters/johndoe.png',
        ]);

        Character::create([
            'name' => 'Jane Smith',
            'role' => 'Mage',
            'age' => 25,
            'filepath' => 'images/characters/janesmith.png',
        ]);
    }
}
