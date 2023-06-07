<?php

namespace App\Schemas;

/**
 * @OA\Schema(
 *     schema="CidadeRequestBody",
 *     title="Corpo da Requisição para Cidade",
 *     description="Esquema de dados para o corpo da requisição ao criar ou atualizar uma cidade",
 * )
 */
class CidadeRequestBody
{
    /**
     * @OA\Property(
     *     property="nome",
     *     type="string",
     *     description="Nome da cidade",
     *     example="São Paulo"
     * )
     *
     * @var string
     */
    public $nome;
}
