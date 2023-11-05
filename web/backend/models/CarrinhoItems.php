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
 *
 * @property Artigos $artigos
 * @property CarrinhoCompras $carrinhocompras
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
            [['artigos_id'], 'exist', 'skipOnError' => true, 'targetClass' => Artigos::class, 'targetAttribute' => ['artigos_id' => 'id']],
            [['carrinhocompras_id'], 'exist', 'skipOnError' => true, 'targetClass' => CarrinhoCompras::class, 'targetAttribute' => ['carrinhocompras_id' => 'id']],
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

    /**
     * Gets query for [[Artigos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArtigos()
    {
        return $this->hasOne(Artigos::class, ['id' => 'artigos_id']);
    }

    /**
     * Gets query for [[Carrinhocompras]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCarrinhocompras()
    {
        return $this->hasOne(CarrinhoCompras::class, ['id' => 'carrinhocompras_id']);
    }
}
