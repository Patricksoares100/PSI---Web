<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "carrinho_items".
 *
 * @property int $id
 * @property int $quantidade
 * @property float $valor
 * @property float $valor_iva
 * @property int $artigos_id
 * @property int $carrinhocompras_id
 */
class CarrinhoItems extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'carrinho_items';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['quantidade', 'valor', 'valor_iva', 'artigos_id', 'carrinhocompras_id'], 'required'],
            [['quantidade', 'artigos_id', 'carrinhocompras_id'], 'integer'],
            [['valor', 'valor_iva'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'quantidade' => 'Quantidade',
            'valor' => 'Valor',
            'valor_iva' => 'Valor Iva',
            'artigos_id' => 'Artigos ID',
            'carrinhocompras_id' => 'Carrinhocompras ID',
        ];
    }
}
