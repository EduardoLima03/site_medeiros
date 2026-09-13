<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AchadoPerdido extends Model
{
    protected $table = 'achados_perdidos';

    protected $fillable = [
        'titulo',
        'descricao',
        'local_encontrado',
        'data_encontrado',
        'imagem',
        'entregue',
        'user_id',
    ];

    protected $casts = [
        'data_encontrado' => 'date',
        'entregue' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeDisponiveis($query)
    {
        return $query->where('entregue', false);
    }
}
