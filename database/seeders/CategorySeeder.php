<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = ['Test category', 'Technology', 'Design', 'Management'];

        foreach ($categories as $category) {
            Category::create(
                ['name' => $category]
            );
        }
    }
}
