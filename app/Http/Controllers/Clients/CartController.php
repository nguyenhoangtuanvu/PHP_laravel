<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Http\Requests\Orders\CreateOrderRequest;
use App\Http\Resources\Cart\CartResource;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    protected $cart;
    protected $product;
    protected $cartProduct;
    protected $coupon;
    protected $order;
    public function __construct(Cart $cart, Product $product, CartProduct $cartProduct, Coupon $coupon, Order $order)
    {
        $this->product = $product;
        $this->cart = $cart;
        $this->cartProduct = $cartProduct;
        $this->coupon = $coupon;
        $this->order = $order;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cart = $this->cart->firstOrCreateBy(auth()->user()->id)->load('products');

        return view('clients.carts.cart', compact('cart'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->size) {
            $product = $this->product->findOrFail($request->product_id);
            $cart = $this->cart->firstOrCreateBy(auth()->user()->id);
            $cartProduct = $this->cartProduct->getBy($cart->id, $product->id, $request->size);
            if ($cartProduct) {
                $quantity = $cartProduct->product_quantity;
                $cartProduct->update(['product_quantity' => $quantity += $request->quantity]);
            } else {
                $dataCreate['cart_id'] = $cart->id;
                $dataCreate['product_quantity'] = $request->quantity ?? 1;
                $dataCreate['product_price'] = $product->price;
                $dataCreate['product_id'] = $request->product_id;
                foreach ($request->size as $size) {
                    $dataCreate['product_size'] = $size;
                    $this->cartProduct->create($dataCreate);
                }
            }
            return  back()->with(['message' => 'Đã thêm thành công']);

        } else {return back()->with(['message' => 'bạn chưa chọn size']);}
    }

    public function updateQuantityProduct(Request $request, $id) {
        $cartProduct =  $this->cartProduct->find($id);
        $dataUpdate = $request->all();
        if($dataUpdate['product_quantity'] < 1 ) {
            $cartProduct->delete();
        } else {
            $cartProduct->update($dataUpdate);
        }

        $cart =  $cartProduct->cart;

        return response()->json([
            'product_cart_id' => $id,
            'cart' => new CartResource($cart),
            'remove_product' => $dataUpdate['product_quantity'] < 1,
            'cart_product_price' => $cartProduct->totalPrice()
        ], Response::HTTP_OK);
    }

    public function deleteProduct($id) {
        $cartProduct = $this->cartProduct->find($id);
        $cartProduct->delete();
        $cart = $cartProduct->cart;
        
        return response()->json([
            'product_cart_id' => $id,
            'cart' => new CartResource($cart)
        ], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     */
    public function applyCoupon(Request $request)  // Can use Ajax
    {
        $name = $request->input('coupon_code');
        $coupon = $this->coupon->getExperyDate($name, auth()->user()->id);
        if ($coupon) { 
            $message = 'Áp dụng Coupon thành công'; 
            Session::put('coupon_id', $coupon->id);
            Session::put('discount_amount_price', $coupon->value);
            Session::put('coupon_code', $coupon->name);
        } 
        else { 
            $message = 'Coupon không tồn tại hoặc đã hết hạn';
            Session::forget(['coupon_id', 'discount_amount_price', 'coupon_code']);
        }
        return redirect()->route('cart')->with(['message' => $message]);
    }

    public function checkOut() {
        $cart = $this->cart->firstOrCreateBy(auth()->user()->id)->load('products');
        return view('clients.carts.checkout', compact('cart'));
    }
    public function processCheckout(CreateOrderRequest $request) {
        $dataCreate = $request->all();
        $dataCreate['user_id'] = auth()->user()->id;
        $dataCreate['status'] = 'pending';
        $dataCreate['payment'] = 'money';
        $this->order->create($dataCreate);

        $couponID = Session::get('coupon_id');
        if ($couponID) {
            $coupon = $this->coupon->find($couponID);
            if ($coupon) {
                $coupon->users()->attach(auth()->user()->id, ['value' => $coupon->value]);
            }
        }
        $cart = $this->cart->firstOrCreateBy(auth()->user()->id);
        $cart->products()->detach();
        
        Session::forget(['coupon_id', 'discount_amount_price', 'coupon_code']);
        return redirect()->route('orders')->with(['message' => 'order successful']);
    }
}   
