<?php

namespace App\Schemas;

/**
 * @OA\Schema(
 *     schema="UserSchema",
 *     title="Usuário",
 *     description="Esquema de dados do usuário",
 * )
 */
class UserSchema
{
    /**
     * @OA\Property(
     *     property="id",
     *     type="integer",
     *     format="int64",
     *     description="ID do usuário",
     *     example=1
     * )
     *
     * @var int
     */
    public $id;

    /**
     * @OA\Property(
     *     property="name",
     *     type="string",
     *     description="Nome do usuário",
     *     example="John Doe"
     * )
     *
     * @var string
     */
    public $name;

    /**
     * @OA\Property(
     *     property="email",
     *     type="string",
     *     format="email",
     *     description="Email do usuário",
     *     example="johndoe@example.com"
     * )
     *
     * @var string
     */
    public $email;

    /**
     * @OA\Property(
     *     property="data_nascimento",
     *     type="string",
     *     format="date",
     *     description="Data de nascimento do usuário",
     *     example="1990-01-01"
     * )
     *
     * @var string
     */
    public $data_nascimento;

    /**
     * @OA\Property(
     *     property="id_cidade",
     *     type="integer",
     *     format="int64",
     *     description="ID da cidade do usuário",
     *     example=1
     * )
     *
     * @var int
     */
    public $id_cidade;

    /**
     * @OA\Property(
     *     property="isGuia",
     *     type="boolean",
     *     description="Indica se o usuário é um guia",
     *     example=true
     * )
     *
     * @var bool
     */
    public $isGuia;

    /**
     * @OA\Property(
     *     property="profile_photo_path",
     *     type="string",
     *     description="Caminho da foto de perfil do usuário",
     *     example="path/to/profile/photo.jpg"
     * )
     *
     * @var string
     */
    public $profile_photo_path;

    /**
     * @OA\Property(
     *     property="profile_banner_path",
     *     type="string",
     *     description="Caminho do banner de perfil do usuário",
     *     example="path/to/profile/banner.jpg"
     * )
     *
     * @var string
     */
    public $profile_banner_path;

    /**
     * @OA\Property(
     *     property="modalidade",
     *     type="array",
     *     description="Modalidades do usuário",
     *     @OA\Items(
     *         type="integer",
     *         example={1, 2, 3}
     *     )
     * )
     */
    public $modalidade;

    /**
     * @OA\Property(
     *     property="telefone",
     *     type="string",
     *     description="Número de telefone do usuário",
     *     example="1234567890"
     * )
     *
     * @var string
     */
    public $telefone;

    /**
     * @OA\Property(
     *     property="facebook_url",
     *     type="string",
     *     description="URL do perfil do usuário no Facebook",
     *     example="https://www.facebook.com/johndoe"
     * )
     *
     * @var string
     */
    public $facebook_url;

    /**
     * @OA\Property(
     *     property="instagram_url",
     *     type="string",
     *     description="URL do perfil do usuário no Instagram",
     *     example="https://www.instagram.com/johndoe"
     * )
     *
     * @var string
     */
    public $instagram_url;

    /**
     * @OA\Property(
     *     property="twitter_url",
     *     type="string",
     *     description="URL do perfil do usuário no Twitter",
     *     example="https://www.twitter.com/johndoe"
     * )
     *
     * @var string
     */
    public $twitter_url;

    /**
     * @OA\Property(
     *     property="bio",
     *     type="string",
     *     description="Biografia do usuário",
     *     example="Lorem ipsum dolor sit amet, consectetur adipiscing elit."
     * )
     *
     * @var string
     */
    public $bio;
}
