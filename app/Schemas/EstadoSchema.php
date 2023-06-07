<?php

namespace App\Schemas;

/**
 * @OA\Schema(
 *     schema="EstadoSchema",
 *     title="Esquema de Estado",
 *     description="Esquema de dados para o recurso de Estado",
 * )
 */
class EstadoSchema
{
    /**
     * @OA\Property(
     *     property="id",
     *     type="integer",
     *     description="ID do estado",
     *     example="1"
     * )
     *
     * @var int
     */
    public $id;

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
     *     ref="#/components/schemas/PaisSchema",
     *     description="País ao qual o estado pertence"
     * )
     *
     * @var \App\Schemas\PaisSchema
     */
    public $pais;

    /**
     * @OA\Property(
     *     property="cidades",
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/CidadeSchema"),
     *     description="Lista de cidades do estado"
     * )
     *
     * @var array
     */
    public $cidades;
}
