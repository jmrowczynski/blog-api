<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    public function run()
    {
        Post::truncate();

        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 50; $i++) {
            $title = $faker->sentence;
            $slug = Str::slug($title, '-');

            Post::create([
                'title' => $title,
                'tags' => $faker->text,
                'category' => $faker->text,
                'content' => $faker->paragraph,
                'author_id' => 1,
                'slug' => $slug
            ]);
        }
    }
}
