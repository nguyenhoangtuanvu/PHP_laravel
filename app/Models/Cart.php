<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
    ];

    public function product(): HasMany
    {
        return $this->hasMany(Product::class, 'Cart_id');
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
}
