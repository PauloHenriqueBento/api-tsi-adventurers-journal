<?php

namespace App\Schemas;

/**
 * @OA\Schema(
 *     schema="EstadoRequestBody",
 *     title="Corpo da Requisição para Estado",
 *     description="Esquema de dados para o corpo da requisição ao criar ou atualizar um estado",
 * )
 */
class EstadoRequestBody
{
    /**
     * @OA\Property(
     *     property="nome",
     *     type="string",
     *     description="Nome do estado",
     *     example="São Paulo"
     * )
     *
     * @var string
     */
    public $nome;

    /**
     * @OA\Property(
     *     property="uf",
     *     type="string",
     *     description="Sigla do estado",
     *     example="SP"
     * )
     *
     * @var string
     */
    public $uf;

    /**
     * @OA\Property(
     *     property="pais",
     *     type="object",
     *     description="País ao qual o estado pertence",
     *     ref="#/components/schemas/PaisSchema"
     * )
     *
     * @var \App\Schemas\PaisSchema
     */
    public $pais;

    /**
     * @OA\Property(
     *     property="cidades",
     *     type="array",
     *     description="Lista de cidades do estado",
     *     @OA\Items(ref="#/components/schemas/CidadeSchema")
     * )
     *
     * @var array
     */
    public $cidades;
}
