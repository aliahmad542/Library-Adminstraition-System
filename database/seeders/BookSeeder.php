<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Book;
use Illuminate\Support\Facades\Hash;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = [
            [
                'title' => 'The Digital Revolution',
                'Description' => 'A comprehensive guide to understanding the digital transformation of our world.',
                'price' => 29.99,
                'file_path' => 'C:\Users\PC\Desktop\Library-Adminstration-System\public\storage',
                'image_path' => 'https://picsum.photos/400/600?random=1',
                'category_id' => 8, // Technology
                'author_id' => 1,
                'author_name'=>'ahmad',
                'admin_id' => 1,
                'quantity' => 50,
            ],
            [
                'title' => 'Mystery of the Lost Cipher',
                'Description' => 'A thrilling mystery novel that will keep you guessing until the very end.',
                'price' => 19.99,
                'file_path' => 'C:\Users\PC\Desktop\Library-Adminstration-System\public\storage',
                'image_path' => 'https://picsum.photos/400/600?random=2',
                'category_id' => 4, // Mystery
                'author_id' => 2,
                'author_name'=>'ahmad',
                'admin_id' => 1,
                'quantity' => 30,
            ],
            [
                'title' => 'Love in the Time of AI',
                'Description' => 'A romantic story exploring human connections in the age of artificial intelligence.',
                'price' => 24.99,
                'file_path' =>'C:\Users\PC\Desktop\Library-Adminstration-System\public\storage',
                'image_path' => 'https://picsum.photos/400/600?random=3',
                'category_id' => 5, // Romance
                'author_id' => 3,
                'author_name'=>'ahmad',
                'admin_id' => 1,
                'quantity' => 25,
            ],
            [
                'title' => 'The Martian Chronicles Revisited',
                'Description' => 'A modern take on space exploration and human colonization of Mars.',
                'price' => 34.99,
                'file_path' => 'C:\Users\PC\Desktop\Library-Adminstration-System\public\storage',
                'image_path' => 'https://picsum.photos/400/600?random=4',
                'category_id' => 3, // Science Fiction
                'author_id' => 4,
                'admin_id' => 1,
                'author_name'=>'ahmad',
                'quantity' => 40,
            ],
            [
                'title' => 'The Art of Mindfulness',
                'Description' => 'Practical techniques for achieving inner peace and mental clarity.',
                'price' => 22.99,
                'file_path' => 'C:\Users\PC\Desktop\Library-Adminstration-System\public\storage',
                'image_path' => 'https://picsum.photos/400/600?random=5',
                'category_id' => 9, // Self-Help
                'author_id' => 5,
                'admin_id' => 1,
                'author_name'=>'ahmad',
                'quantity' => 35,
            ],
            [
                'title' => 'Historical Perspectives on Modern Politics',
                'Description' => 'An analysis of how historical events shape contemporary political landscapes.',
                'price' => 39.99,
                'file_path' => 'C:\Users\PC\Desktop\Library-Adminstration-System\public\storage',
                'image_path' => 'https://picsum.photos/400/600?random=6',
                'category_id' => 7, // History
                'author_id' => 1,
                'admin_id' => 1,
                'author_name'=>'ahmad',
                'quantity' => 20,
            ],
            [
                'title' => 'The Entrepreneur\'s Journey',
                'Description' => 'Real stories from successful entrepreneurs and their path to success.',
                'price' => 27.99,
                'file_path' => 'C:\Users\PC\Desktop\Library-Adminstration-System\public\storage',
                'image_path' => 'https://picsum.photos/400/600?random=7',
                'category_id' => 13, // Business
                'author_id' => 2,
                'admin_id' => 1,
                'author_name'=>'ahmad',
                'quantity' => 45,
            ],
            [
                'title' => 'Whispers of the Forest',
                'Description' => 'A fantasy adventure about a young girl who discovers she can communicate with nature.',
                'price' => 16.99,
                'file_path' => 'C:\Users\PC\Desktop\Library-Adminstration-System\public\storage',
                'image_path' => 'https://picsum.photos/400/600?random=8',
                'category_id' => 10, // Children's Books
                'author_id' => 3,
                'admin_id' => 1,
                'author_name'=>'ahmad',
                'quantity' => 60,
            ],
            [
                'title' => 'The Philosophy of Existence',
                'Description' => 'Deep philosophical reflections on the meaning of life and human existence.',
                'price' => 32.99,
                'file_path' => 'C:\Users\PC\Desktop\Library-Adminstration-System\public\storage',
                'image_path' => 'https://picsum.photos/400/600?random=9',
                'category_id' => 12, // Philosophy
                'author_id' => 4,
                'author_name'=>'ahmad',
                'admin_id' => 1,
                'quantity' => 15,
            ],
            [
                'title' => 'Wanderlust: A Traveler\'s Guide',
                'Description' => 'Essential tips and hidden gems for the modern traveler.',
                'price' => 25.99,
                'file_path' => 'C:\Users\PC\Desktop\Library-Adminstration-System\public\storage',
                'image_path' => 'https://picsum.photos/400/600?random=10',
                'category_id' => 15, // Travel
                'author_id' => 5,
                'admin_id' => 1,
                'author_name'=>'ahmad',
                'quantity' => 30,
            ],
        ];

        foreach ($books as $book) {
            Book::create($book);
        }
    }
}
