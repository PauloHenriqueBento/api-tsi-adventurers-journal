<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destino extends Model
{
    use HasFactory;

    protected $fillable = ['nome','descrição','cidade_id','CEP'];

    protected $primaryKey = 'id';

    protected $table = 'destino';

    public $incrementing = true;

    public $timestamps = true;

    //Relacionamento entre Estado e Cidade
    public function cidade()
    {
        return $this->belongsTo(Cidade::class, 'cidade_id','id');
    }
}
