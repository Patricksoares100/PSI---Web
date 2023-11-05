<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "carrinho_compras".
 *
 * @property int $id
 * @property string $data
 * @property float $valor_total
 * @property int $iva_total
 * @property int $pessoas_id
 * @property string|null $estado
 */
class CarrinhoCompras extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'carrinho_compras';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['data', 'valor_total', 'iva_total', 'pessoas_id'], 'required'],
            [['data'], 'safe'],
            [['valor_total'], 'number'],
            [['iva_total', 'pessoas_id'], 'integer'],
            [['estado'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'data' => 'Data',
            'valor_total' => 'Valor Total',
            'iva_total' => 'Iva Total',
            'pessoas_id' => 'Pessoas ID',
            'estado' => 'Estado',
        ];
    }
}
