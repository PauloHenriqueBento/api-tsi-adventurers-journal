<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItensDoCarrinho extends Model
{
    use HasFactory;

    protected $fillable = ['nome','idViajante','idAtividade','qtdPessoa'];

    protected $primaryKey = 'id';

    protected $table = 'itens_do_carrinho';

    public $incrementing = true;

    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class, 'idViajante','id');
    }

    public function atividade()
    {
        return $this->hasMany(Atividade::class,  'idAtividade','id');
    }
}
