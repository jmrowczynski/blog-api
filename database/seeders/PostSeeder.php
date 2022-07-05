<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run()
    {
        Post::truncate();

        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 50; $i++) {
            Post::create([
                'title' => $faker->sentence,
                'tags' => $faker->text,
                'category' => $faker->text,
                'content' => $faker->paragraph,
                'author_id' => 1
            ]);
        }
    }
}
