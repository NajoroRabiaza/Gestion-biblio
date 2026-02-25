<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Author;

class AuthorSeeder extends Seeder
{
    public function run()
    {
        Author::create(['name' => 'Victor Hugo', 'nationality' => 'Français']);
        Author::create(['name' => 'Albert Camus', 'nationality' => 'Français']);
        Author::create(['name' => 'Robert Martin', 'nationality' => 'Américain']);
    }
}