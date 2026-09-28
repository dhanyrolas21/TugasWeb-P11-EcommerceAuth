<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat User Admin, Editor, dan User biasa
        $admin = User::create([
            'name' => 'Admin Store',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $editor = User::create([
            'name' => 'Editor Content',
            'email' => 'editor@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'editor',
        ]);

        $user = User::create([
            'name' => 'Customer Biasa',
            'email' => 'user@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        // 2. Buat Kategori
        $categories = collect(['Elektronik', 'Pakaian', 'Aksesoris', 'Buku', 'Peralatan Rumah'])->map(function ($name) {
            return Category::create(['name' => $name, 'slug' => Str::slug($name)]);
        });

        // 3. Buat Tags
        $tags = collect(['Promo', 'Terlaris', 'Terbaru', 'Import', 'Lokal'])->map(function ($name) {
            return Tag::create(['name' => $name, 'slug' => Str::slug($name)]);
        });

        // 4. Generate 50+ Produk
        for ($i = 1; $i <= 55; $i++) {
            $name = "Produk E-Commerce #" . $i;
            $product = Product::create([
                'category_id' => $categories->random()->id,
                'user_id' => $admin->id,
                'name' => $name,
                'slug' => Str::slug($name),
                'description' => "Deskripsi lengkap untuk produk berkualitas ke-" . $i,
                'price' => rand(50000, 2500000),
                'stock' => rand(5, 100),
                'is_active' => true,
            ]);

            // Tempelkan tag acak ke produk
            $product->tags()->attach($tags->random(rand(1, 3))->pluck('id'));
        }

        // 5. Buat Sampel Order & Order Items
        $order = Order::create([
            'user_id' => $user->id,
            'order_number' => 'ORD-' . strtoupper(Str::random(8)),
            'total_amount' => 1500000,
            'status' => 'completed',
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => 1,
            'quantity' => 2,
            'price' => 750000,
        ]);
    }
}