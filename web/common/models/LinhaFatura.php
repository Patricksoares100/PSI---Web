<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "linhas_faturas".
 *
 * @property int $id
 * @property int $quantidade
 * @property float $valor
 * @property float $valor_iva
 * @property int $artigo_id
 * @property int $fatura_id
 *
 * @property Artigos $artigo
 * @property Faturas $fatura
 */
class LinhaFatura extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'linhas_faturas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['quantidade', 'valor', 'valor_iva', 'artigo_id', 'fatura_id'], 'required'],
            [['quantidade', 'artigo_id', 'fatura_id'], 'integer'],
            [['valor', 'valor_iva'], 'number'],
            [['artigo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Artigo::class, 'targetAttribute' => ['artigo_id' => 'id']],
            [['fatura_id'], 'exist', 'skipOnError' => true, 'targetClass' => Fatura::class, 'targetAttribute' => ['fatura_id' => 'id']],
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
            'fatura_id' => 'Fatura ID',
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
     * Gets query for [[Fatura]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFatura()
    {
        return $this->hasOne(Fatura::class, ['id' => 'fatura_id']);
    }
}
