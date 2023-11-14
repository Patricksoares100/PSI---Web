<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "empresa".
 *
 * @property int $id
 * @property string $nome
 * @property string $email
 * @property int $telefone
 * @property int $nif
 * @property int $morada
 * @property string $codigo_postal
 * @property string $localidade
 */
class Empresa extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'empresa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome', 'email', 'telefone', 'nif', 'morada', 'codigo_postal', 'localidade'], 'required'],
            [['telefone', 'nif', 'morada'], 'integer'],
            [['nome', 'email', 'codigo_postal', 'localidade'], 'string', 'max' => 255],
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
            'email' => 'Email',
            'telefone' => 'Telefone',
            'nif' => 'NIF',
            'morada' => 'Morada',
            'codigo_postal' => 'Código Postal',
            'localidade' => 'Localidade',
        ];
    }
}
