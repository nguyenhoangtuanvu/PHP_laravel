<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientProductController extends Controller
{
    protected $product, $category;

    public function __construct(Product $product, Category $category) {
        $this->product = $product;
        $this->category = $category;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = $this->product->with('details')->latest('id')->paginate(10);
        return view('clients.products.products')->with('products', $products);
    }
    public function indexFilter(Request $request, $category_id)
    {
        $products = $this->product->getBy($request->all(), $category_id);
        // dd($products);
 
        return view('clients.products.products')->with('products', $products);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = $this->product->with('details')->findOrFail($id);
        return view('clients.products.shop_detail')->with('product', $product);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
