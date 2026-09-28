<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;

class ProductPolicy
{
    public function update(User $user, Product $product): bool
    {
        // Admin dan Editor boleh update semua produk, User biasa hanya produk miliknya
        return in_array($user->role, ['admin', 'editor']) || $user->id === $product->user_id;
    }

    public function delete(User $user, Product $product): bool
    {
        // Hanya Admin yang berhak menghapus produk
        return $user->role === 'admin';
    }
}