<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategoryField extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function formField()
    {
        return $this->belongsTo(FormField::class, 'field_id');
    }
}
