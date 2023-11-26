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
            [['telefone', 'nif'], 'integer'],
            [['nome', 'email', 'codigo_postal', 'localidade', 'morada'], 'string', 'max' => 255],

            [['nome', 'email', 'telefone', 'nif', 'morada', 'codigo_postal', 'localidade'], 'trim'],// trim é para remover espaços em branco do início e do final do valor do atributo

            ['nome', 'string', 'min' => 2, 'max' => 255],

            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\Empresa', 'message' => 'Este email já está a ser usado!'],

            ['telefone', 'required'],
            ['telefone', 'match', 'pattern' => '^\d{9}?$^', 'message' => 'Número de telefone incorreto'],
            ['telefone', 'string', 'max' => 9, 'message' => 'Número de telefone incorreto'],

            ['nif', 'required'],
            ['nif', 'match', 'pattern' => '^\d{9}?$^', 'message' => 'NIF inválido'],
            ['nif', 'string', 'max' => 9, 'message' => 'NIF inválido'],
            ['nif', 'unique', 'targetClass' => '\common\models\Empresa', 'message' => 'Este NIF já está a ser usado!'],

            ['codigo_postal', 'required'],
            ['codigo_postal', 'match', 'pattern' => '^\d{4}-\d{3}?$^', 'message' => 'Insira o código postal neste formato: xxxx-xxx'],
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
