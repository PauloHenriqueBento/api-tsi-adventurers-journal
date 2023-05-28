<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Atividade extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'idViajante',
        'idGuia',
        'idModalidade',
        'idCidade',
        'nota',
        'comentario',
        'data',
    ];

    public function viajante()
    {
        return $this->belongsTo(User::class, 'idViajante');
    }

    public function guia()
    {
        return $this->belongsTo(User::class, 'idGuia');
    }

    public function modalidade()
    {
        return $this->belongsTo(Modalidade::class, 'idModalidade');
    }

    public function cidade()
    {
        return $this->belongsTo(Cidade::class, 'idCidade');
    }
}
