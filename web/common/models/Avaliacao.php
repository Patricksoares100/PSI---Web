<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "avaliacaos".
 *
 * @property int $id
 * @property string $comentario
 * @property string|null $classificacao
 * @property int $artigo_id
 * @property int $perfil_id
 *
 * @property Artigos $artigo
 * @property Perfis $perfil
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
            [['comentario', 'artigo_id', 'perfil_id'], 'required'],
            [['classificacao'], 'string'],
            [['artigo_id', 'perfil_id'], 'integer'],
            [['comentario'], 'string', 'max' => 255],
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
            'comentario' => 'Comentário',
            'classificacao' => 'Classificação',
            'artigo_id' => 'Artigo ID',
            'perfil_id' => 'Perfil ID',
            'artigo.nome' => 'Nome do Artigo',
            'perfil.nome' => 'Nome do Cliente'
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

    public static function getNumeroAvaliacoes()
    {
        return static::find()->count();
    }

    public static function getMediaAvaliacoes($id){
        $avaliacoes = Avaliacao::find()->where(['artigo_id' => $id])->all();
        $somaTotal = 0;
            foreach ($avaliacoes as $avaliacao) {
                $somaTotal += $avaliacao->classificacao;
            }

            if (count($avaliacoes) > 0) {
                return ceil($somaTotal / count($avaliacoes));
            }
        return 0;
    }
    public static function getNumAvaliacoes($id){
        $avaliacoes = Avaliacao::find()->where(['artigo_id' => $id])->all();
        return count($avaliacoes);
    }
}
