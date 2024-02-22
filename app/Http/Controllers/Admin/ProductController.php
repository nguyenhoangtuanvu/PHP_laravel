<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Products\CreateProductRequest;
use App\Http\Requests\Products\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductDetail;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $category;
    protected $product;
    protected $productDetail;

    function __construct(Product $product, Category $category, ProductDetail $productDetail) {
        $this->category = $category;
        $this->product = $product;
        $this->productDetail = $productDetail;
    }
    public function index()
    {
        $products = $this->product->latest('id')->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = $this->category->get(['id', 'name']);
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateProductRequest $request)
    {
        $dataCreate = $request->all();
        $sizes = $request->sizes ? json_decode($request->sizes) : [];
        
        $dataCreate['image'] = $this->product->saveImage($request);

        $product = Product::create($dataCreate);
        $product->images()->create([ 'url' => $dataCreate['image']]);
        $product->categories()->attach($dataCreate['category_ids']);
        $sizeArray = [];
        foreach ($sizes as $size) {
            $sizeArray[] = ['size' => $size->size, 'quantity' => $size->quantity, 'product_id' => $product->id];
        }
        $this->productDetail->insert($sizeArray);
        return to_route('products.index')->with(['message' => 'create successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = $this->product->with(['details', 'categories'])->findOrFail($id);
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = $this->product->with(['details', 'categories'])->findOrFail($id);
        $categoryList = $this->category->get(['id', 'name']);
        return view('admin.products.edit', compact('product', 'categoryList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, string $id)
    {
        $product = $this->product->findOrFail($id);

        $dataUpdate = $request->except('sizes');
        $sizes = $request->sizes ? json_decode($request->sizes) : [];
        
        $currentImage = $product?->images?->first()?->url;
        $dataUpdate['image'] = $this->product->updateImage($request, $currentImage);

        $product->update($dataUpdate);
        $product->images()->delete();
        $product->images()->create([ 'url' => $dataUpdate['image']]);
        $product->assignCategory($dataUpdate['category_ids']);
        $sizeArray = [];
        foreach ($sizes as $size) {
            $sizeArray[] = ['size' => $size->size, 'quantity' => $size->quantity, 'product_id' => $product->id];
        }
        $product->details()->delete();
        $this->productDetail->insert($sizeArray);
        return to_route('products.index')->with(['message' => 'update successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = $this->product->findOrFail($id);
        $product->details()->delete();
        $image = $product?->images?->first()?->url;
        $this->product->deleteImage($image);
        $product->images()->delete();

        $product->delete();
        return to_route('products.index')->with(['message' => 'delete successfully']);

    }
}
