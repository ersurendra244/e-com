<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'

    ];

    public function itemTypeList()
    {
        return Item::whereIn('id', $this->item_type ?? [])
                    ->get();
    }


    protected $casts = [
        'item_type' => 'array',
    ];
}
