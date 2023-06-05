<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modalidade extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'descricao',
        'photo_path'
    ];

    public function users()
    {
        return $this->belongsToMany(users::class, 'user_modalidade', 'modalidades_id', 'users_id');
    }

    public function atividades()
    {
        return $this->belongsToMany(Atividade::class, 'atividade_modalidade', 'modalidade_id', 'atividade_id');
    }
}
