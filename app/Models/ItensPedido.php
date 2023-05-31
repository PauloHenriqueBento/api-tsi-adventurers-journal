<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItensPedido extends Model
{
    use HasFactory;

    protected $fillable = ['idUsuario','idAtividade','status','DatadoPedido','TotalPedido','FormaPag','qtdPessoa'];

    protected $primaryKey = 'id';

    protected $table = 'itensDoPedido';

    public $incrementing = true;

    public $timestamps = true;

    public function user() {
        return $this->belongsTo(User::class, 'idUsuario','id');
    }

    public function Atividade() {
        return $this->hasMany(Atividade::class, 'idAtividade','id');
    }
   
}
