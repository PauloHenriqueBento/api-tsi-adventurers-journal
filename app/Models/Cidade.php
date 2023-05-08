<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cidade extends Model
{
    use HasFactory;

    protected $fillable = ['nome','estado_id'];

    protected $primaryKey = 'id';

    protected $table = 'cidade';

    public $incrementing = true;

    public $timestamps = true;

    //Relacionamento entre Estado e Cidade
    public function estado()
    {
        return $this->belongsTo(Estado::class, 'estado_id','id');
    }
}
