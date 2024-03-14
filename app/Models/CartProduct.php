<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartProduct extends Model
{
    use HasFactory;
    protected $fillable = [
        'cart_id',
        'product_id',
        'product_size',
        'product_quantity',
        'product_price',
    ];
    
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    public function getBy($cartId, $productId, $productSize)
    {
        return CartProduct::whereCartId($cartId)->whereProductId($productId)->whereProductSize($productSize)->first();
    }
    public function totalPrice() {
        return $this->product_price * $this->product_quantity;
    }
}
