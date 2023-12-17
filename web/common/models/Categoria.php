<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "categorias".
 *
 * @property int $id
 * @property string $nome
 *
 * @property Artigo[] $artigos
 */
class Categoria extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categorias';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome'], 'required','message' => 'O Campo não pode estar vazio!'],
            [['nome'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome da Categoria',
        ];
    }

    /**
     * Gets query for [[Artigos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArtigos()
    {
        return $this->hasMany(Artigo::class, ['categoria_id' => 'id']);
    }

    public static function getNumeroCategorias(){

        return static::find()->count();
    }
    public static function canDeleteCategoria($id)
    {
        // ver se existe algum artigo relacionado
        $artigosRelacionados = Artigo::find()->where(['categoria_id' => $id])->one();

        // Se existir, retorna false senao  true
        return $artigosRelacionados ? false : true;
    }
}
