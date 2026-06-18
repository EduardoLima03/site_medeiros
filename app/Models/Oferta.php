<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Oferta extends Model
{
    protected $fillable = ['titulo', 'tipo', 'arquivo', 'thumb', 'ativa', 'data_inicio', 'data_fim', 'user_id'];

    protected $casts = [
        'data_inicio' => 'date',
        'data_fim' => 'date',
        'ativa' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeAtivas($query)
    {
        return $query->where('ativa', true);
    }

    public function scopeVigentes($query)
    {
        $hoje = now()->format('Y-m-d');
        return $query->where('ativa', true)
            ->where(function ($q) use ($hoje) {
                $q->whereNull('data_fim')->orWhere('data_fim', '>=', $hoje);
            });
    }
}
