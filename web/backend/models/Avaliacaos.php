<?php

namespace app\models;

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
 * @property Artigos $artigos
 * @property Pessoas $pessoas
 */
class Avaliacaos extends \yii\db\ActiveRecord
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
            [['artigos_id'], 'exist', 'skipOnError' => true, 'targetClass' => Artigos::class, 'targetAttribute' => ['artigos_id' => 'id']],
            [['pessoas_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pessoas::class, 'targetAttribute' => ['pessoas_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'comentario' => 'Comentario',
            'classificacao' => 'Classificacao',
            'artigos_id' => 'Artigos ID',
            'pessoas_id' => 'Pessoas ID',
        ];
    }

    /**
     * Gets query for [[Artigos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArtigos()
    {
        return $this->hasOne(Artigos::class, ['id' => 'artigos_id']);
    }

    /**
     * Gets query for [[Pessoas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPessoas()
    {
        return $this->hasOne(Pessoas::class, ['id' => 'pessoas_id']);
    }
}
