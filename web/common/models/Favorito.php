<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "favoritos".
 *
 * @property int $id
 * @property int $artigo_id
 * @property int $perfil_id
 *
 * @property Artigo $artigo
 * @property Perfil $perfil
 */
class Favorito extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'favoritos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['artigo_id', 'perfil_id'], 'required'],
            [['artigo_id', 'perfil_id'], 'integer'],
            [['artigo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Artigo::class, 'targetAttribute' => ['artigo_id' => 'id']],
            [['perfil_id'], 'exist', 'skipOnError' => true, 'targetClass' => Perfil::class, 'targetAttribute' => ['perfil_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'artigo_id' => 'Artigo ID',
            'perfil_id' => 'Perfil ID',
        ];
    }

    /**
     * Gets query for [[Artigo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArtigo()
    {
        return $this->hasOne(Artigo::class, ['id' => 'artigo_id']);
    }

    /**
     * Gets query for [[Perfil]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPerfil()
    {
        return $this->hasOne(Perfil::class, ['id' => 'perfil_id']);
    }
}
