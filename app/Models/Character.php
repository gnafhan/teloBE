<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'role', 'age', 'filepath',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($character) {
            if (Character::where('name', $character->name)->where('age', $character->age)->exists()) {
                throw new \Exception('Character with the same name and age already exists.');
            }
        });

        static::updating(function ($character) {
            if (Character::where('name', $character->name)->where('age', $character->age)->where('id', '<>', $character->id)->exists()) {
                throw new \Exception('Character with the same name and age already exists.');
            }
        });
    }
}
