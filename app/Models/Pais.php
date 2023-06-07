<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    use HasFactory;

    protected $fillable = ['nome'];

    //Relacionamento entre Pais e Estado
    public function estado()
    {
        return $this->hasMany(Estado::class, 'pais_id', 'id');
    }
}
