<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidatura extends Model
{
    protected $fillable = ['vaga_id', 'user_id', 'status'];

    public function vaga()
    {
        return $this->belongsTo(Vaga::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function curriculo()
    {
        return $this->hasOne(Curriculo::class, 'user_id', 'user_id')->latestOfMany();
    }
}
