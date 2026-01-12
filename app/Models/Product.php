<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';

    protected $guarded = [];
    protected $casts = [
        'variant_data' => 'array',
        'variant_images' => 'array'
    ];

    public function reviews()
    {
        return $this->hasMany(Review::class, 'id');
    }

    public function mainCategory()
    {
        return $this->belongsTo(Category::class, 'main_cat_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'cat_id');
    }

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_cat_id');
    }
}
