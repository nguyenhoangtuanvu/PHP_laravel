<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'cart_products')->withPivot('id', 'product_quantity', 'product_size');
    }

    public function getBy($userId) {
        return Cart::whereUserId($userId)->first();
    }

    public function firstOrCreateBy($userId) {
        $cart = $this->getBy($userId);
        if(!$cart) {
            $cart = $this->cart->create(['user_id' => $userId]);
        }
        return $cart;
    }

    public function getProductCount()
    {
        return auth()->check() ? $this->products->count() : 0;
    }

    public function getTotalPrice()
    {
        return auth()->check() ? $this->products->reduce(function ($carry, $item) {
            $price = $item->pivot->product_quantity * $item->price;
            return $carry += $price;
        }, 0) : 0;
    }
}
