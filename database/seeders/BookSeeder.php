<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Author;
use App\Models\Review;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $c1 = Category::create(['name' => "Technology"]);
        $c2 = Category::create(['name' => "Science"]);
        $c3 = Category::create(['name' => "Programming"]);
        $c4 = Category::create(['name' => "Physics"]);
        $c5 = Category::create(['name' => "Maths"]);

        $a1 = Author::create(['name' => 'J .Smith']);
        $a2 = Author::create(['name' => 'A .Other']);
        $a3 = Author::create(['name' => 'P. Weiss']);

        // create 3 defined books
        $b1 = Book::create([
            "title" => "HTML5",
            "year" => 2022,
            "rating" => 3.0,
            'category_id' => $c1->id,
            "description" => "The Definitive Guide to HTML5 provides the breadth of information you'll need to start creating the next generation of HTML5 websites. It covers all the base knowledge required for standards-compliant, semantic, modern website creation"
        ]);

        // Attach authors and reviews directly within relationships
        $b1->authors()->saveMany([$a1, $a2]);
        $b1->reviews()->createMany(Review::factory()->count(fake()->numberBetween(0, 20))->make()->toArray());


        $b2 = Book::create([
            "title" => "CSS3",
            "year" => 2022,
            "rating" => 3.0,
            'category_id' => $c1->id,
            "description" => "CSS3 is full of …"
        ]);
        $b2->authors()->saveMany([$a2]);
        $b2->reviews()->createMany(Review::factory()->count(fake()->numberBetween(0, 20))->make()->toArray());

        $b3 = Book::create([
            "title" => "PHP8",
            "year" => 2023,
            "rating" => 4.5,
            'category_id' => $c1->id,
            "description" => "Learn how to…"
        ]);
        $b3->authors()->saveMany([$a1]);
        $b3->reviews()->createMany(Review::factory()->count(fake()->numberBetween(0, 20))->make()->toArray());


        // create 20 random books
        $categories = Category::get();
        $authors = Author::get();
        Book::factory(20)
            ->create(['category_id' => $categories->random()->id])
            ->each(
                function ($book) use ($authors) {
                    $book->authors()->attach($authors->random(rand(0, 3)));
                    $book->reviews()->createMany(Review::factory(5)->make()->toArray());
                }
            );
    }
}
