<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first() ?? User::factory()->create(['role' => 'admin']);
        $categoryElektronik = Category::firstOrCreate(['name' => 'Elektronik'], ['slug' => 'elektronik']);

        $products = [
            [
                'name' => 'Laptop Performance',
                'description' => 'Laptop untuk kuliah, kerja, dan pemrograman dengan performa tinggi.',
                'price' => 20500000,
                'stock' => 15,
            ],
            [
                'name' => 'Smartphone 5G',
                'description' => 'Smartphone modern dengan jaringan 5G untuk kebutuhan sehari-hari.',
                'price' => 27000000,
                'stock' => 20,
            ],
            [
                'name' => 'Headphone Wireless',
                'description' => 'Audio nyaman dengan noise cancelling untuk belajar dan hiburan.',
                'price' => 11500000,
                'stock' => 12,
            ],
            [
                'name' => 'Smartwatch Active',
                'description' => 'Jam pintar dengan pelacak kesehatan untuk aktivitas sehari-hari.',
                'price' => 18200000,
                'stock' => 8,
            ],
            [
                'name' => 'Gaming Mouse',
                'description' => 'Mouse ergonomis dengan sensor presisi tinggi untuk gaming.',
                'price' => 3500000,
                'stock' => 30,
            ],
            [
                'name' => 'Mechanical Keyboard',
                'description' => 'Keyboard mekanis yang nyaman, responsif, dan tahan lama.',
                'price' => 4000000,
                'stock' => 25,
            ],
            [
                'name' => 'Monitor IPS 24 Inch',
                'description' => 'Monitor dengan warna akurat untuk belajar, kerja, dan hiburan.',
                'price' => 5400000,
                'stock' => 10,
            ],
            [
                'name' => 'TWS Earbuds',
                'description' => 'Earbuds wireless dengan desain ringkas dan suara jernih.',
                'price' => 2000000,
                'stock' => 40,
            ]
        ];

        foreach ($products as $item) {
            Product::create([
                'category_id' => $categoryElektronik->id,
                'user_id' => $admin->id,
                'name' => $item['name'],
                'slug' => Str::slug($item['name']),
                'description' => $item['description'],
                'price' => $item['price'],
                'stock' => $item['stock'],
                'is_active' => true,
            ]);
        }
    }
}