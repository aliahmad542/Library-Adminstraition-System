<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Request;
class RequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $requests = [
            ['user_id' => 1, 'book_id' => 1, 'quantity' => 2],
            ['user_id' => 1, 'book_id' => 3, 'quantity' => 1],
            ['user_id' => 2, 'book_id' => 2, 'quantity' => 6],
            ['user_id' => 2, 'book_id' => 4, 'quantity' => 9],
            ['user_id' => 3, 'book_id' => 5, 'quantity' => 2],
            ['user_id' => 3, 'book_id' => 1, 'quantity' => 1],
            ['user_id' => 4, 'book_id' => 6, 'quantity' => 2],
            ['user_id' => 4, 'book_id' => 7, 'quantity' => 1],
        ];

        foreach ($requests as $request) {
            Request::create($request);
        }
    }
}
