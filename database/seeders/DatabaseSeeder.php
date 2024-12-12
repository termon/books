<?php

namespace Database\Seeders;

use App\Enums\Role;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'password' => Hash::make('password'),
            'role' => Role::ADMIN
        ]);

        User::create([
            'name' => 'Author',
            'email' => 'author@mail.com',
            'password' => Hash::make('password'),
            'role' => Role::AUTHOR
        ]);

        User::create([
            'name' => 'Guest',
            'email' => 'guest@mail.com',
            'password' => Hash::make('password'),
            'role' => Role::GUEST
        ]);

        $this->call([
            BookSeeder::class
        ]);
    }
}
