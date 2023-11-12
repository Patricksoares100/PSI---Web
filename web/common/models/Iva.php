<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ivas".
 *
 * @property int $id
 * @property string|null $em_vigor
 * @property string $descricao
 * @property float $percentagem
 *
 * @property Artigo[] $artigos
 */
class Iva extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ivas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['em_vigor'], 'string'],
            [['descricao', 'percentagem'], 'required'],
            [['percentagem'], 'number'],
            [['descricao'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'em_vigor' => 'Em Vigor',
            'descricao' => 'Descricao',
            'percentagem' => 'Percentagem',
        ];
    }

    /**
     * Gets query for [[Artigos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArtigos()
    {
        return $this->hasMany(Artigo::class, ['iva_id' => 'id']);
    }
}
