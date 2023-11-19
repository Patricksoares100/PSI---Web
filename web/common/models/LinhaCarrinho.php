<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "linhas_carrinho".
 *
 * @property int $id
 * @property int $quantidade
 * @property int $artigo_id
 * @property int $perfil_id
 *
 * @property Artigos $artigo
 * @property Perfis $perfil
 */
class LinhaCarrinho extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'linhas_carrinho';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['quantidade', 'artigo_id', 'perfil_id'], 'required'],
            [['quantidade', 'artigo_id', 'perfil_id'], 'integer'],
            [['artigo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Artigos::class, 'targetAttribute' => ['artigo_id' => 'id']],
            [['perfil_id'], 'exist', 'skipOnError' => true, 'targetClass' => Perfis::class, 'targetAttribute' => ['perfil_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'quantidade' => 'Quantidade',
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
        return $this->hasOne(Artigos::class, ['id' => 'artigo_id']);
    }

    /**
     * Gets query for [[Perfil]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPerfil()
    {
        return $this->hasOne(Perfis::class, ['id' => 'perfil_id']);
    }
}
