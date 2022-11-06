<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
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
                'content' => $faker->paragraph,
                'author_id' => User::inRandomOrder()->first('id')->id,
                'category_id' => Category::inRandomOrder()->first('id')->id,
                'slug' => $slug,
                'excerpt' => $faker->sentence(10)
            ]);
        }
    }
}
