<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "avaliacaos".
 *
 * @property int $id
 * @property string $comentario
 * @property string|null $classificacao
 * @property int $artigos_id
 * @property int $pessoas_id
 *
 * @property Artigo $artigos
 * @property Pessoa $pessoas
 */
class Avaliacao extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'avaliacaos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['comentario', 'artigos_id', 'pessoas_id'], 'required'],
            [['classificacao'], 'string'],
            [['artigos_id', 'pessoas_id'], 'integer'],
            [['comentario'], 'string', 'max' => 255],
            [['artigos_id'], 'exist', 'skipOnError' => true, 'targetClass' => Artigo::class, 'targetAttribute' => ['artigos_id' => 'id']],
            [['pessoas_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pessoa::class, 'targetAttribute' => ['pessoas_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'comentario' => 'Comentário',
            'classificacao' => 'Classificação',
            'artigos_id' => 'Nome do Artigo',
            'artigos.nome' => 'Nome do Artigo',
            'pessoas.nome' => 'Cliente',
        ];
    }

    /**
     * Gets query for [[Artigo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArtigos()
    {
        return $this->hasOne(Artigo::class, ['id' => 'artigos_id']);
    }

    /**
     * Gets query for [[Pessoa]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPessoas()
    {
        return $this->hasOne(Pessoa::class, ['id' => 'pessoas_id']);
    }
}
