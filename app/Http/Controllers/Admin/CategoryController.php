<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Categories\CreateCategoryRequest;
use App\Models\Category;

class CategoryController extends Controller
{
    protected $category;
    public function __construct(Category $category) {
        $this->category = $category;
    }

    public function index()
    {
        $category = $this->category::latest('id')->paginate(10);
        return view('admin.categories.index', compact('category'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parent = $this->category->getParents();
        return view('admin.categories.create', compact('parent'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCategoryRequest $request)
    {
        $dataCreate = $request->all();
        $categories = Category::create($dataCreate);
        return to_route('categories.index')->with(['message' => 'create successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = $this->category->with('children')->findOrFail($id);
        $parent = $this->category->with('parent')->findOrFail($id);
        $parentList = $this->category->getParents();
        return view('admin.categories.edit', compact('category','parent','parentList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all());
        $dataUpdate = $request->all();
        $category = $this->category->findOrFail($id);
        $category->update($dataUpdate);

        return to_route('categories.index')->with(['message' => 'updated ' . $category->name. ' successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = $this->category->findOrFail($id);
        $category->delete();

        return to_route('categories.index')->with(['message' => 'delete ' . $category->name. ' successfully']);
    }
}
