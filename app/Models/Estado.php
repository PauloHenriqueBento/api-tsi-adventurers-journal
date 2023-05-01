<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    use HasFactory;

    protected $fillable = ['nome','uf'];

    protected $primaryKey = 'id';

    protected $table = 'estado';

    public $incrementing = true;

    public $timestamps = true;


    //Relacionamento entre Pais e Estado
    public function Pais()
    {
        return $this->belongsTo(Pais::class);
    }

}
