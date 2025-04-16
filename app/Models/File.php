<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'filename',
        'uploadfile',
        'remark',
        'created_by',
    ];

    public function shares()
    {
        return $this->hasMany(FileShare::class, 'file_id');
    }
}
