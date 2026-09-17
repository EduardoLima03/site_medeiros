<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageBlock extends Model
{
    protected $fillable = ['page', 'type', 'titulo', 'conteudo', 'imagem', 'link', 'ordem', 'ativo'];

    protected $casts = [
        'ativo' => 'boolean',
    ];

    public function slides()
    {
        return $this->hasMany(PageBlockSlide::class)->orderBy('ordem');
    }

    public function scopeDaPagina($query, $page)
    {
        return $query->where('page', $page);
    }

    public function scopeAtivos($query)
    {
        return $query->where('ativo', true);
    }

    public function scopeOrdenados($query)
    {
        return $query->orderBy('ordem');
    }
}
