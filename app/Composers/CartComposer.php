<?php

namespace App\Composers;

use App\Models\Cart;
use Illuminate\View\View;

class CartComposer
{
    /**
     * The user repository implementation.
     *
     * @var \App\Repositories\UserRepository
     */
    protected $cart;

    /**
     * Create a new profile composer.
     *
     * @param  \App\Repositories\UserRepository  $users
     * @return void
     */
    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    }

    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('productInCart', $this->ProductInCart());
        $view->with('totalProductInCart', $this->getTotal());
    }

    public function ProductInCart()
    {
        if(auth()->check()) {
           $cart =  $this->cart->firstOrCreateBy(auth()->user()->id)->load('products');
           return $cart;
        }

    }
    public function getTotal() {
        if(auth()->check()) { 
            $cart = $this->ProductInCart();
            return $cart->getTotalPrice();
        }
    }
}
