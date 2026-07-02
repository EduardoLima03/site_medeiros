<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'telefone', 'cpf',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function vagas()
    {
        return $this->hasMany(Vaga::class);
    }

    public function candidaturas()
    {
        return $this->hasMany(Candidatura::class);
    }

    public function curriculos()
    {
        return $this->hasMany(Curriculo::class);
    }
}
