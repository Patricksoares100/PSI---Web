<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "fornecedores".
 *
 * @property int $id
 * @property string|null $nome
 * @property int|null $telefone
 * @property int|null $nif
 * @property string|null $morada
 *
 * @property Artigos[] $artigos
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
            ['nif', 'trim'],
            ['nif', 'required'],
            ['nif', 'match', 'pattern' => '^\d{9}?$^', 'message' => 'Insira o NIF no seguinte formato xxxx-xxx'],
            ['nif', 'string', 'max' => 9, 'message' => 'Insira o NIF no seguinte formato xxxx-xxx'],
            ['nif', 'unique', 'targetClass' => '\common\models\Fornecedor', 'message' => 'Este NIF já está a ser usado!'],
            ['telefone', 'trim'],
            ['telefone', 'required'],
            ['telefone', 'match', 'pattern' => '^\d{9}?$^', 'message' => 'Número de telefone incorreto'],
            ['telefone', 'string', 'max' => 9, 'message' => 'Número de telefone incorreto'],
            ['telefone', 'unique', 'targetClass' => '\common\models\Fornecedor', 'message' => 'Este telefone já está a ser usado!'],
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
            'nome' => 'Nome do Fornecedor',
            'telefone' => 'Telefone',
            'nif' => 'NIF',
            'morada' => 'Morada',
        ];
    }

    /**
     * Gets query for [[Artigos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArtigos()
    {
        return $this->hasMany(Artigos::class, ['fornecedor_id' => 'id']);
    }

    public static function getNumeroFornecedores(){

        return static::find()->count();
    }
}
