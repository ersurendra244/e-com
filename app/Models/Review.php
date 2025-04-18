<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table = 'reviews';

    protected $guarded = [];

    public function product() {
        return $this->belongsTo(Product::class, 'pid');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }



}
