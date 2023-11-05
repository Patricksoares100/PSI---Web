<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "avaliacaos".
 *
 * @property int $id
 * @property string $comentario
 * @property int $artigos_id
 * @property int $pessoas_id
 * @property string|null $classificacao
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
            [['artigos_id', 'pessoas_id'], 'integer'],
            [['classificacao'], 'string'],
            [['comentario'], 'string', 'max' => 255],
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
            'artigos_id' => 'Artigos ID',
            'pessoas_id' => 'Pessoas ID',
            'classificacao' => 'Classificacao',
        ];
    }
}
