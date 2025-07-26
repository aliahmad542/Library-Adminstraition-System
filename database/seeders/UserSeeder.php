<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'firstname' => 'Alice',
                'lastname' => 'Johnson',
                'location' => 'New York',
                'email' => 'alice@example.com',
                'password' => Hash::make('password123'),
                'is_banned' => false,
            ],
            [
                'firstname' => 'Bob',
                'lastname' => 'Smith',
                'location' => 'Los Angeles',
                'email' => 'bob@example.com',
                'password' => Hash::make('password123'),
                'is_banned' => false,
            ],
            [
                'firstname' => 'Charlie',
                'lastname' => 'Brown',
                'location' => 'Chicago',
                'email' => 'charlie@example.com',
                'password' => Hash::make('password123'),
                'is_banned' => false,
            ],
            [
                'firstname' => 'Diana',
                'lastname' => 'Prince',
                'location' => 'Miami',
                'email' => 'diana@example.com',
                'password' => Hash::make('password123'),
                'is_banned' => false,
            ],
            [
                'firstname' => 'Eve',
                'lastname' => 'Wilson',
                'location' => 'Seattle',
                'email' => 'eve@example.com',
                'password' => Hash::make('password123'),
                'is_banned' => true, // One banned user for testing
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
