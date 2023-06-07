<?php

namespace App\Schemas;

/**
 * @OA\Schema(
 *     schema="PaisSchema",
 *     title="Esquema de País",
 *     description="Esquema de dados para o recurso de País",
 * )
 */
class PaisSchema
{
    /**
     * @OA\Property(
     *     property="identify",
     *     type="integer",
     *     description="ID do país",
     *     example="1"
     * )
     *
     * @var int
     */
    public $identify;

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

    /**
     * @OA\Property(
     *     property="estado",
     *     ref="#/components/schemas/EstadoSchema",
     *     description="Estado associado ao país"
     * )
     *
     * @var EstadoSchema
     */
    public $estado;
}
