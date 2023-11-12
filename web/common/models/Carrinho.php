<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "carrinhos".
 *
 * @property int $id
 * @property float $valor_total
 * @property int $iva_total
 * @property string $data
 *
 * @property LinhasCarrinho[] $linhasCarrinhos
 * @property Perfi[] $perfis
 */
class Carrinho extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'carrinhos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['valor_total', 'iva_total', 'data'], 'required'],
            [['valor_total'], 'number'],
            [['iva_total'], 'integer'],
            [['data'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'valor_total' => 'Valor Total',
            'iva_total' => 'Iva Total',
            'data' => 'Data',
        ];
    }

    /**
     * Gets query for [[LinhasCarrinhos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhasCarrinhos()
    {
        return $this->hasMany(LinhasCarrinho::class, ['carrinho_id' => 'id']);
    }

    /**
     * Gets query for [[Perfis]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPerfis()
    {
        return $this->hasMany(Perfi::class, ['carrinho_id' => 'id']);
    }
}
