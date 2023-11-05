<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "artigos".
 *
 * @property int $id
 * @property string $nome
 * @property string $descricao
 * @property float $valor
 * @property int $stock_atual
 * @property int $iva_id
 * @property int $fornecedores_id
 * @property int $categorias_id
 * @property int $pessoas_id
 */
class Artigo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'artigos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome', 'descricao', 'valor', 'stock_atual', 'iva_id', 'fornecedores_id', 'categorias_id', 'pessoas_id'], 'required'],
            [['valor'], 'number'],
            [['stock_atual', 'iva_id', 'fornecedores_id', 'categorias_id', 'pessoas_id'], 'integer'],
            [['nome', 'descricao'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome',
            'descricao' => 'Descricao',
            'valor' => 'Valor',
            'stock_atual' => 'Stock Atual',
            'iva_id' => 'Iva ID',
            'fornecedores_id' => 'Fornecedores ID',
            'categorias_id' => 'Categorias ID',
            'pessoas_id' => 'Pessoas ID',
        ];
    }
}
