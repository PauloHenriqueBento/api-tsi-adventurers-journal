<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'uf', 'pais_id'];

    protected $primaryKey = 'id';

    protected $table = 'estado';

    public $incrementing = true;

    public $timestamps = true;


    //Relacionamento entre Pais e Estado
    public function pais()
    {
        return $this->belongsTo(Pais::class, 'pais_id', 'id');
    }

    public function cidade()
    {
        return $this->hasMany(Cidade::class, 'estado_id', 'id');
    }
}
