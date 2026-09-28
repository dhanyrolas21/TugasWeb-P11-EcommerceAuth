<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'user_id', 'name', 'slug', 'description', 'price', 'stock', 'is_active'];

    // Local Scope: Filter produk yang aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Local Scope: Filter produk di bawah harga tertentu
    public function scopeCheap($query, $price = 1000000)
    {
        return $query->where('price', '<=', $price);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}