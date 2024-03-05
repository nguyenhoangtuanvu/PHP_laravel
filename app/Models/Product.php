<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductDetail;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\HandleImageTrait;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;
    use HandleImageTrait;
    protected $fillable = [
        'name',
        'description',
        'sale',
        'price'
    ];
    public function details(): HasMany 
    {
        return $this->hasMany(ProductDetail::class);
    }
    public function categories(): BelongsToMany 
    {
        return $this->belongsToMany(Category::class, 'category_product', 'product_id', 'category_id');
    }
    public function assignCategory($categories_ids) {
        return $this->categories()->sync($categories_ids);
    }

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageAble');
    }
    
    public function getBy($dataGet, $category_id) {
        return $this->whereHas('categories', fn($query) => $query->where('category_id', '=', $category_id))->get();
    }
}
