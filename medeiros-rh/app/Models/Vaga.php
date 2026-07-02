<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vaga extends Model
{
    protected $fillable = ['titulo', 'descricao', 'imagem', 'status', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function candidaturas()
    {
        return $this->hasMany(Candidatura::class);
    }
}
