<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assinatura extends Model
{
    use HasFactory;

    protected $fillable = ['nome','preco'];

    protected $primaryKey = 'id';

    protected $table = 'assinatura';

    public $incrementing = true;

    public $timestamps = true;

}