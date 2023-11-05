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
 * @property string|null $estado
 * @property int $pessoas_id
 *
 * @property CarrinhoItems[] $carrinhoItems
 * @property Pessoas $pessoas
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
            [['pessoas_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pessoas::class, 'targetAttribute' => ['pessoas_id' => 'id']],
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
            'estado' => 'Estado',
            'pessoas_id' => 'Pessoas ID',
        ];
    }

    /**
     * Gets query for [[CarrinhoItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCarrinhoItems()
    {
        return $this->hasMany(CarrinhoItems::class, ['carrinhocompras_id' => 'id']);
    }

    /**
     * Gets query for [[Pessoas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPessoas()
    {
        return $this->hasOne(Pessoas::class, ['id' => 'pessoas_id']);
    }
}
