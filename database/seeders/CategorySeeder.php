<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        Category::create(['name' => 'Roman', 'description' => 'Les romans']);
        Category::create(['name' => 'Science', 'description' => 'livre scientifiques']);
        Category::create(['name' => 'Histoire', 'description' => 'livre historiques']);
        Category::create(['name' => 'Informatique', 'description' => 'livre sur informatique']);
    }
}