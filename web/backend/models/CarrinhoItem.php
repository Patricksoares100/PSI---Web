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
 * @property Artigo $artigos
 * @property CarrinhoCompra $carrinhocompras
 */
class CarrinhoItem extends \yii\db\ActiveRecord
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
            [['artigos_id'], 'exist', 'skipOnError' => true, 'targetClass' => Artigo::class, 'targetAttribute' => ['artigos_id' => 'id']],
            [['carrinhocompras_id'], 'exist', 'skipOnError' => true, 'targetClass' => CarrinhoCompra::class, 'targetAttribute' => ['carrinhocompras_id' => 'id']],
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
            'artigos_id' => 'Artigo ID',
            'carrinhocompras_id' => 'Carrinhocompras ID',
        ];
    }

    /**
     * Gets query for [[Artigo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArtigos()
    {
        return $this->hasOne(Artigo::class, ['id' => 'artigos_id']);
    }

    /**
     * Gets query for [[Carrinhocompras]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCarrinhocompras()
    {
        return $this->hasOne(CarrinhoCompra::class, ['id' => 'carrinhocompras_id']);
    }
}
