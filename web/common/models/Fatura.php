<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "faturas".
 *
 * @property int $id
 * @property string $data
 * @property float $valor_fatura
 * @property string|null $estado
 */
class Fatura extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'faturas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['data', 'valor_fatura'], 'required'],
            [['data'], 'safe'],
            [['valor_fatura'], 'number'],
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
            'valor_fatura' => 'Valor Fatura',
            'estado' => 'Estado',
        ];
    }
}
