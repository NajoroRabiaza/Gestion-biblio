<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    public function run()
    {
        Book::create([
            'title' => 'Les 3 Misérables',
            'author_id' => 1,
            'category_id' => 1,
            'total_copies' => 3,
            'available_copies' => 3,
        ]);

        Book::create([
            'title' => 'Etranger dans la nature',
            'author_id' => 2,
            'category_id' => 1,
            'total_copies' => 2,
            'available_copies' => 2,
        ]);

        Book::create([
            'title' => 'Coder Proprement',
            'author_id' => 3,
            'category_id' => 4,
            'total_copies' => 5,
            'available_copies' => 5,
        ]);
    }
}