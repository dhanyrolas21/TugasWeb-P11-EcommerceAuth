<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat User Bawaan untuk Testing Multi-Role
        User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            ['name' => 'Admin System', 'password' => Hash::make('password'), 'role' => 'admin']
        );

        User::firstOrCreate(
            ['email' => 'editor@gmail.com'],
            ['name' => 'Editor Konten', 'password' => Hash::make('password'), 'role' => 'editor']
        );

        User::firstOrCreate(
            ['email' => 'user@gmail.com'],
            ['name' => 'Customer Biasa', 'password' => Hash::make('password'), 'role' => 'user']
        );

        // 2. Panggil ProductSeeder Katalog NexTechCommerce
        $this->call([
            ProductSeeder::class,
        ]);
    }
}