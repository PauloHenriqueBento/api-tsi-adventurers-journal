<?php

namespace App\Schemas;

/**
 * @OA\Schema(
 *     schema="CidadeSchema",
 *     title="Esquema de Cidade",
 *     description="Esquema de dados para o recurso de Cidade",
 * )
 */
class CidadeSchema
{
    /**
     * @OA\Property(
     *     property="id",
     *     type="integer",
     *     description="ID da cidade",
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
     *     description="Nome da cidade",
     *     example="São Paulo"
     * )
     *
     * @var string
     */
    public $nome;

    /**
     * @OA\Property(
     *     property="estado",
     *     ref="#/components/schemas/EstadoSchema",
     *     description="Estado ao qual a cidade pertence"
     * )
     *
     * @var \App\Schemas\EstadoSchema
     */
    public $estado;
}
