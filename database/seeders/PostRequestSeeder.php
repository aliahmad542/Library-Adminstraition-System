<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PostRequest;

class PostRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $postRequests = [
            [
                'title' => 'Advanced Machine Learning Techniques',
                'description' => 'A comprehensive guide to modern ML algorithms and their applications.',
                'file_path' => 'C:\Users\PC\Desktop\Library-Adminstration-System\public\storage',
                'price' => '45.99',
                'author_id' => 1,
                'category_id' => 8, // Technology
                'admin_id' => 1,
                'quantity' => 100,
                'status' => 'pending',
            ],
            [
                'title' => 'The Quantum Paradox',
                'description' => 'Exploring the mysteries of quantum physics in an accessible way.',
                'file_path' => 'C:\Users\PC\Desktop\Library-Adminstration-System\public\storage',
                'price' => '38.99',
                'author_id' => 2,
                'category_id' => 3, // Science Fiction
                'admin_id' => 1,
                'quantity' => 75,
                'status' => 'approved',
            ],
            [
                'title' => 'Cooking with Love',
                'description' => 'Traditional recipes passed down through generations.',
                'file_path' => 'C:\Users\PC\Desktop\Library-Adminstration-System\public\storage',
                'price' => '28.99',
                'author_id' => 3,
                'category_id' => 2, // Non-Fiction
                'admin_id' => 1,
                'quantity' => 50,
                'status' => 'rejected',
            ],
            [
                'title' => 'Digital Marketing Mastery',
                'description' => 'Complete guide to succeeding in digital marketing.',
                'file_path' => 'C:\Users\PC\Desktop\Library-Adminstration-System\public\storage',
                'price' => '35.99',
                'author_id' => 4,
                'category_id' => 13, // Business
                'admin_id' => 1,
                'quantity' => 80,
                'status' => 'pending',
            ],
            [
                'title' => 'Poems of the Heart',
                'description' => 'A collection of heartfelt poetry about love, loss, and hope.',
                'file_path' => 'C:\Users\PC\Desktop\Library-Adminstration-System\public\storage',
                'price' => '18.99',
                'author_id' => 5,
                'category_id' => 11, // Poetry
                'admin_id' => 1,
                'quantity' => 40,
                'status' => 'approved',
            ],
        ];

        foreach ($postRequests as $postRequest) {
            PostRequest::create($postRequest);
        }
    }
}
