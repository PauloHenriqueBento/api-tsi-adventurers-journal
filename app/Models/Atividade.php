<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Atividade extends Model
{
    use HasFactory;

    protected $fillable = [
        'IdGuia',
        'preco',
        'idCidade',
        'Titulo',
        'Descricao',
        'DataTime',
        'IdadeMinima'
    ];

    public function guia()
    {
        return $this->belongsTo(User::class, 'IdGuia');
    }

    public function cidade()
    {
        return $this->belongsTo(Cidade::class, 'idCidade');
    }

    public function modalidades()
    {
        return $this->belongsToMany(Modalidade::class, 'atividade_modalidade');
    }
    public function itensDoCarrinho()
    {
        //Tirar duvida se é belongsTo ou belongsToMany
        return $this->belongsTo(ItensDoCarrinho::class,  'idAtividade','id');
    }
}
