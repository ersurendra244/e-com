<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileManager extends Model
{
    use HasFactory;
    protected $table = 'file_manager';

    protected $guarded = [];

    public function parent()
    {
        return $this->belongsTo(FileManager::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(FileManager::class, 'parent_id');
    }

    public function scopeFolders($query)
    {
        return $query->where('type', 'folder');
    }

    public function scopeImages($query)
    {
        return $query->where('type', 'image');
    }

    public function scopeFiles($query)
    {
        return $query->where('type', 'file');
    }

    public function getTotalSize()
    {
        // If it's a file or image, return its own size
        if ($this->type !== 'folder') {
            return $this->size ?? 0;
        }

        // If it's a folder, recursively sum the size of all children
        $totalSize = 0;

        foreach ($this->children as $child) {
            $totalSize += $child->getTotalSize(); // recursive
        }

        return $totalSize;
    }
    public function getTotalSizeFormattedAttribute()
    {
        $size = $this->getTotalSize();
        return $size > 0 ? round($size / 1024, 2) . ' KB' : '0 KB';
    }
}
