<?php

namespace App\Schemas;

/**
 * @OA\Schema(
 *     schema="ModalidadeSchema",
 *     title="Modalidade",
 *     description="Esquema de dados para a modalidade",
 * )
 */
class ModalidadeSchema
{
    /**
     * @OA\Property(
     *     property="id",
     *     type="integer",
     *     description="ID da modalidade",
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
     *     description="Nome da modalidade",
     *     example="Natação"
     * )
     *
     * @var string
     */
    public $nome;

    /**
     * @OA\Property(
     *     property="descricao",
     *     type="string",
     *     description="Descrição da modalidade",
     *     example="Modalidade esportiva de natação"
     * )
     *
     * @var string
     */
    public $descricao;

    /**
     * @OA\Property(
     *     property="photo_path",
     *     type="string",
     *     description="Caminho da foto da modalidade",
     *     example="/path/to/photo.jpg"
     * )
     *
     * @var string
     */
    public $photo_path;
}
