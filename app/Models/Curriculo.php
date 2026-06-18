<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curriculo extends Model
{
    protected $fillable = ['user_id', 'nome', 'email', 'telefone', 'endereco', 'familia', 'idade', 'sexo', 'objetivo', 'formacao', 'experiencia_profissional', 'arquivo', 'observacao'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
