<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = ['filename', 'original_name', 'path', 'mime_type', 'size'];

    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->path);
    }
}
