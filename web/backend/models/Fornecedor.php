<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fornecedores".
 *
 * @property int $id
 * @property string|null $nome
 * @property int|null $telefone
 * @property int|null $nif
 * @property string|null $morada
 */
class Fornecedor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fornecedores';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['telefone', 'nif'], 'integer'],
            [['nome', 'morada'], 'string', 'max' => 255],
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
            'telefone' => 'Telefone',
            'nif' => 'Nif',
            'morada' => 'Morada',
        ];
    }
}
