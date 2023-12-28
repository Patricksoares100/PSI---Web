<?php

namespace common\models;
use yii\web\UploadedFile;
use common\models\Imagem;

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

    /**
     * @var UploadedFile[]
     */

    public $imageFiles;
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
            [['nome','imageFiles'], 'required','message' => 'O Campo não pode estar vazio!'],
            [['nome'], 'string', 'max' => 255],
            [['imageFiles'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'maxFiles' => 4],
        ];
    }

    public function upload()
    {
        if (!$this->validate()) {
            return false;
        }

        foreach ($this->imageFiles as $file) {
            $timestamp = date('YmdHis');
            $path = 'uploads/' . $file->baseName . '_' . $timestamp . '.' . $file->extension;
            $file->saveAs($path);


            $imagem = new Imagem();
            $imagem->categoria_id = $this->id;
            $imagem->image_path = $path;
            $imagem->save();
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome da Categoria',
            'imagem.image_path' => 'Imagens',
        ];
    }

    public function getImagens()
    {
        return $this->hasMany(Imagem::class, ['categoria_id' => 'id']);
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
