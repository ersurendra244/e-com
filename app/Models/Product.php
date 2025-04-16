<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';

    public function variants() {
        return $this->hasMany(Variant::class, 'product_id');
    }
    public function reviews() {
        return $this->hasMany(Review::class, 'pid');
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    protected $casts = [
        'images' => 'array',
    ];
}
