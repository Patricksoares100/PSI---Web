<?php

namespace common\models;

use Yii;
use common\models\Artigo;

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
            [['telefone', 'nif'], 'integer','message' => 'O Campo tem de ser preenchido com algarismos!'],
            ['nif', 'trim'],
            [['telefone','nif','nome','morada'], 'required','message' => 'O Campo não pode estar vazio!'],
            ['nif', 'match', 'pattern' => '^\d{9}?$^', 'message' => 'Insira o NIF no seguinte formato xxxx-xxx'],
            ['nif', 'string', 'max' => 9, 'message' => 'Insira o NIF no seguinte formato xxxx-xxx'],
            ['nif', 'unique', 'targetClass' => '\common\models\Fornecedor', 'message' => 'Este NIF já está a ser usado!'],
            ['telefone', 'trim'],

            ['telefone', 'match', 'pattern' => '^\d{9}?$^', 'message' => 'Número de telefone incorreto, insira 9 algarismos'],
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
        return $this->hasMany(Artigo::class, ['fornecedor_id' => 'id']);
    }

    public static function getNumeroFornecedores(){

        return static::find()->count();
    }
    public static function canDeleteFornecedor($id)
    {
        // ver se existe algum artigo relacionado
        $artigosRelacionados = Artigo::find()->where(['fornecedor_id' => $id])->one();

        // Se existir, retorna false senao  true
        return $artigosRelacionados ? false : true;
    }
}
