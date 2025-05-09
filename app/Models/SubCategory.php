<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubCategory extends Model
{
    use HasFactory;
    protected $table = 'sub_categories';

    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class, 'cat_id');
    }

    public function itemTypeList()
    {
        return Master::whereIn('id', $this->item_type ?? [])
                    ->where('type', 'item_type')
                    ->get();
    }


    protected $casts = [
        'item_type' => 'array',
    ];
}
