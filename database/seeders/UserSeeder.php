<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Jakub Mrówczyński',
            'email' => 'jmrowczynski12@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('poziomki'), // password
            'remember_token' => Str::random(10),
            'avatar' => null,
        ]);
        User::factory()->count(10)->create();
    }
}
