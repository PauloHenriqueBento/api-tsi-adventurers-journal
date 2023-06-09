<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'data_nascimento',
        'id_cidade',
        'isGuia',
        'profile_photo_path',
        'profile_banner_path',
        'modalidade',
        'telefone',
        'facebook_url',
        'instagram_url',
        'twitter_url',
        'bio',
        'assinatura_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function modalidades()
    {
        return $this->belongsToMany(Modalidade::class, 'user_modalidade', 'users_id', 'modalidades_id');
    }

    public function cidade()
    {
        return $this->belongsTo(User::class, 'id_cidade', 'id');
    }

    public function itensDoCarrinho()
    {
        return $this->hasMany(ItensDoCarrinho::class,  'idViajante', 'id');
    }

    public function assinatura()
    {
        return $this->belongsTo(Assinatura::class);
    }
}
