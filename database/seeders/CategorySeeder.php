<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run()
    {
        DB::transaction(function () {

            $categories = [
                'Electronics' => [
                    'Phones' => ['Smartphones', 'Feature Phones', 'Accessories'],
                    'Computers' => ['Laptops', 'Desktops', 'Tablets'],
                    'TVs & Home Appliances' => ['LED TVs', 'Washing Machines']
                ],
                'Clothing' => [
                    'Men\'s Clothing' => ['Men\'s Shirts', 'Men\'s Pants', 'Men\'s Jackets', 'Men\'s T-shirts'],
                    'Women\'s Clothing' => ['Dresses', 'Women\'s Tops', 'Skirts', 'Women\'s Trousers'],
                ],
                'Books' => [
                    'Fiction' => ['Science Fiction', 'Mystery', 'Romance'],
                    'Children\'s Books' => ['Picture Books', 'Board Books', 'Fairy Tales'],
                    'Study books' => ['Programming Books', 'Literary Books', 'Mathematics Books'],
                    'Sports' => ['Sports Books', 'Fitness Books', 'Coaching Books'],
                    'Others' => ['Magazines', 'Comics']
                ],
                'Furniture' => [
                    'Kitchen Furniture' => ['Kitchen Tables', 'Chairs', 'Storage'],
                    'Living Room Furniture' => ['Sofas', 'Armchairs', 'TV Stands'],
                    'Bedroom Furniture' => ['Beds', 'Wardrobes', 'Nightstands']
                ],
                'Food' => [
                    'Fruits and Vegetables' => ['Fresh Fruits', 'Frozen Vegetables', 'Organic Produce'],
                    'Dairy Products' => ['Milk', 'Cheese', 'Yogurt'],
                    'Snacks' => ['Chips', 'Cookies', 'Nuts']
                ],
                'Toys' => [
                    'Outdoor Toys' => ['Bikes', 'Skateboards'],
                    'Indoor Toys' => ['Board Games', 'Puzzles'],
                    'Educational Toys' => ['Building Blocks', 'STEM Kits']
                ],
                'Beauty' => [
                    'Makeup' => ['Lipsticks', 'Mascara', 'Foundation'],
                    'Skincare' => ['Face Creams', 'Masks', 'Serums'],
                    'Haircare' => ['Shampoos', 'Conditioners', 'Hair Treatments']
                ],
            ];

            foreach ($categories as $parentName => $subcategories) {
                $parentCategory = Category::create([
                    'name' => $parentName,
                    'slug' => Str::slug($parentName),
                    'parent_id' => null
                ]);

                foreach ($subcategories as $subName => $childCategories) {
                    $subCategory = Category::create([
                        'name' => $subName,
                        'slug' => Str::slug($subName),
                        'parent_id' => $parentCategory->id
                    ]);

                    foreach ($childCategories as $childName) {
                        Category::create([
                            'name' => $childName,
                            'slug' => Str::slug($childName),
                            'parent_id' => $subCategory->id
                        ]);
                    }
                }
            }
        });
    }
}
