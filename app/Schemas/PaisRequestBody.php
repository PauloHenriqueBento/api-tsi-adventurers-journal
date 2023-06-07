<?php

namespace App\Schemas;

/**
 * @OA\Schema(
 *     schema="PaisRequestBody",
 *     title="Corpo da Requisição para País",
 *     description="Esquema de dados para o corpo da requisição ao criar ou atualizar um país",
 * )
 */
class PaisRequestBody
{
    /**
     * @OA\Property(
     *     property="nome",
     *     type="string",
     *     description="Nome do país",
     *     example="Brasil"
     * )
     *
     * @var string
     */
    public $nome;
}
