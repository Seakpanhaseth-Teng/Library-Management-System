<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@library.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'Librarian User',
            'email' => 'librarian@library.com',
            'password' => bcrypt('password'),
            'role' => 'librarian',
        ]);

        User::factory()->create([
            'name' => 'Member User',
            'email' => 'member@library.com',
            'password' => bcrypt('password'),
            'role' => 'member',
        ]);

        User::factory()->count(5)->member()->create();

        $this->call([
            BookSeeder::class,
        ]);
    }
}
