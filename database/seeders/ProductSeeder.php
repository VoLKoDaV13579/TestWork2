<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run()
    {

        $categories = [
            'electronics' => Category::where('slug', 'electronics')->first(),
            'clothing' => Category::where('slug', 'clothing')->first(),
            'books' => Category::where('slug', 'books')->first(),
            'smartphones' => Category::where('slug', 'smartphones')->first(),
            'laptops' => Category::where('slug', 'laptops')->first(),
            'men_clothing' => Category::where('slug', 'mens-clothing')->first(),
            'women_clothing' => Category::where('slug', 'womens-clothing')->first(),
            'fiction' => Category::where('slug', 'fiction')->first(),
            'children_books' => Category::where('slug', 'childrens-books')->first(),
        ];


        foreach ($categories as $key => $category) {
            if (!$category) {
                $this->command->warn("Category with slug '{$key}' not found. Skipping related products.");
                continue;
            }
        }



        if ($categories['smartphones']) {
            Product::create([
                'name' => 'Samsung Galaxy S23 Smartphone',
                'slug' => Str::slug('Samsung Galaxy S23 Smartphone'),
                'description' => 'Modern smartphone with excellent features.',
                'price' => 899.99,
                'category_id' => $categories['smartphones']->id,
            ]);
            Product::create([
                'name' => 'iPhone 14 Pro',
                'slug' => Str::slug('iPhone 14 Pro'),
                'description' => 'The latest iPhone with powerful features.',
                'price' => 1099.99,
                'category_id' => $categories['smartphones']->id,
            ]);
            Product::create([
                'name' => 'Google Pixel 7',
                'slug' => Str::slug('Google Pixel 7'),
                'description' => 'Smartphone with amazing camera and clean Android experience.',
                'price' => 799.99,
                'category_id' => $categories['smartphones']->id,
            ]);
        }


        if ($categories['laptops']) {
            Product::create([
                'name' => 'Apple MacBook Air M2',
                'slug' => Str::slug('Apple MacBook Air M2'),
                'description' => 'Lightweight and powerful laptop for work and study.',
                'price' => 1199.99,
                'category_id' => $categories['laptops']->id,
            ]);
            Product::create([
                'name' => 'Dell XPS 13',
                'slug' => Str::slug('Dell XPS 13'),
                'description' => 'Compact and powerful laptop for professionals.',
                'price' => 999.99,
                'category_id' => $categories['laptops']->id,
            ]);
            Product::create([
                'name' => 'HP Spectre x360',
                'slug' => Str::slug('HP Spectre x360'),
                'description' => 'Convertible laptop with top-notch performance.',
                'price' => 1399.99,
                'category_id' => $categories['laptops']->id,
            ]);
        }


        if ($categories['men_clothing']) {
            Product::create([
                'name' => 'Nike T-shirt',
                'slug' => Str::slug('Nike T-shirt'),
                'description' => 'Quality t-shirt for sports and everyday wear.',
                'price' => 29.99,
                'category_id' => $categories['men_clothing']->id,
            ]);
            Product::create([
                'name' => 'Adidas Sweatpants',
                'slug' => Str::slug('Adidas Sweatpants'),
                'description' => 'Comfortable sweatpants for casual wear.',
                'price' => 49.99,
                'category_id' => $categories['men_clothing']->id,
            ]);
            Product::create([
                'name' => 'Puma Hoodie',
                'slug' => Str::slug('Puma Hoodie'),
                'description' => 'Warm hoodie for colder days.',
                'price' => 59.99,
                'category_id' => $categories['men_clothing']->id,
            ]);
        }


        if ($categories['women_clothing']) {
            Product::create([
                'name' => 'Levi\'s Jeans',
                'slug' => Str::slug('Levi\'s Jeans'),
                'description' => 'Classic jeans for everyday wear.',
                'price' => 79.99,
                'category_id' => $categories['women_clothing']->id,
            ]);
            Product::create([
                'name' => 'Zara Blouse',
                'slug' => Str::slug('Zara Blouse'),
                'description' => 'Elegant blouse for a formal look.',
                'price' => 49.99,
                'category_id' => $categories['women_clothing']->id,
            ]);
            Product::create([
                'name' => 'H&M Skirt',
                'slug' => Str::slug('H&M Skirt'),
                'description' => 'Fashionable skirt for daily wear.',
                'price' => 39.99,
                'category_id' => $categories['women_clothing']->id,
            ]);
        }


        if ($categories['books']) {
            Product::create([
                'name' => 'The Lord of the Rings',
                'slug' => Str::slug('The Lord of the Rings'),
                'description' => 'Epic fantasy by J.R.R. Tolkien.',
                'price' => 19.99,
                'category_id' => $categories['books']->id,
            ]);
            Product::create([
                'name' => 'Python Programming',
                'slug' => Str::slug('Python Programming'),
                'description' => 'A book for beginner Python developers.',
                'price' => 24.99,
                'category_id' => $categories['books']->id,
            ]);
        }


        if ($categories['fiction']) {
            Product::create([
                'name' => '1984 by George Orwell',
                'slug' => Str::slug('1984 by George Orwell'),
                'description' => 'Dystopian novel about a totalitarian regime.',
                'price' => 14.99,
                'category_id' => $categories['fiction']->id,
            ]);
            Product::create([
                'name' => 'The Great Gatsby',
                'slug' => Str::slug('The Great Gatsby'),
                'description' => 'Classic novel by F. Scott Fitzgerald.',
                'price' => 12.99,
                'category_id' => $categories['fiction']->id,
            ]);
        }


        if ($categories['children_books']) {
            Product::create([
                'name' => 'The Very Hungry Caterpillar',
                'slug' => Str::slug('The Very Hungry Caterpillar'),
                'description' => 'A classic children\'s book.',
                'price' => 7.99,
                'category_id' => $categories['children_books']->id,
            ]);
            Product::create([
                'name' => 'Harry Potter and the Sorcerer\'s Stone',
                'slug' => Str::slug('Harry Potter and the Sorcerer\'s Stone'),
                'description' => 'The first book in the Harry Potter series.',
                'price' => 14.99,
                'category_id' => $categories['children_books']->id,
            ]);
        }
    }
}
