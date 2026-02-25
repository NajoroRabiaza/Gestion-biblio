<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin Biblio',
            'email' => 'admin@biblio.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        
        User::create([
            'name' => 'test',
            'email' => 'test@biblio.com',
            'password' => Hash::make('123456789'),
            'role' => 'client',
        ]);
    }
}