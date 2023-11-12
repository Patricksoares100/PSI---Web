<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "linhas_carrinho".
 *
 * @property int $id
 * @property int $quantidade
 * @property float $valor
 * @property float $valor_iva
 * @property int $artigo_id
 * @property int $carrinho_id
 *
 * @property Artigo $artigo
 * @property Carrinho $carrinho
 */
class LinhaCarrinho extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'linhas_carrinho';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['quantidade', 'valor', 'valor_iva', 'artigo_id', 'carrinho_id'], 'required'],
            [['quantidade', 'artigo_id', 'carrinho_id'], 'integer'],
            [['valor', 'valor_iva'], 'number'],
            [['artigo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Artigo::class, 'targetAttribute' => ['artigo_id' => 'id']],
            [['carrinho_id'], 'exist', 'skipOnError' => true, 'targetClass' => Carrinho::class, 'targetAttribute' => ['carrinho_id' => 'id']],
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
            'artigo_id' => 'Artigo ID',
            'carrinho_id' => 'Carrinho ID',
        ];
    }

    /**
     * Gets query for [[Artigo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArtigo()
    {
        return $this->hasOne(Artigo::class, ['id' => 'artigo_id']);
    }

    /**
     * Gets query for [[Carrinho]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCarrinho()
    {
        return $this->hasOne(Carrinho::class, ['id' => 'carrinho_id']);
    }
}
