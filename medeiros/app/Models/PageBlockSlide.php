<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageBlockSlide extends Model
{
    protected $fillable = ['page_block_id', 'imagem', 'link', 'titulo', 'ordem'];

    public function block()
    {
        return $this->belongsTo(PageBlock::class, 'page_block_id');
    }
}