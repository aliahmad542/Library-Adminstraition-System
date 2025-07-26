<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Author;
use Illuminate\Support\Facades\Hash;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $authors = [
            [
                'firstname' => 'Emily',
                'lastname' => 'Richardson',
                'location' => 'London',
                'email' => 'emily.richardson@authors.com',
                'password' => Hash::make('password123'),
            ],
            [
                'firstname' => 'Michael',
                'lastname' => 'Thompson',
                'location' => 'Toronto',
                'email' => 'michael.thompson@authors.com',
                'password' => Hash::make('password123'),
            ],
            [
                'firstname' => 'Isabella',
                'lastname' => 'Garcia',
                'location' => 'Barcelona',
                'email' => 'isabella.garcia@authors.com',
                'password' => Hash::make('password123'),
            ],
            [
                'firstname' => 'James',
                'lastname' => 'Mitchell',
                'location' => 'Sydney',
                'email' => 'james.mitchell@authors.com',
                'password' => Hash::make('password123'),
            ],
            [
                'firstname' => 'Sophia',
                'lastname' => 'Lee',
                'location' => 'Seoul',
                'email' => 'sophia.lee@authors.com',
                'password' => Hash::make('password123'),
            ],
        ];

        foreach ($authors as $author) {
            Author::create($author);
        }
    }
    }

