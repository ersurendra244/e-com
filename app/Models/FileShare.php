<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileShare extends Model
{
    use HasFactory;

    protected $table = 'file_shares';

    protected $guarded = [];

    public function file()
    {
        return $this->belongsTo(File::class, 'file_id');
    }
}
