<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "pessoas".
 *
 * @property int $id
 * @property string $nome
 * @property int $telefone
 * @property int $nif
 * @property string $morada
 * @property string $codigo_postal
 * @property string $localidade
 *
 * @property Artigo[] $artigos
 * @property Avaliacao[] $avaliacaos
 * @property CarrinhoCompra[] $carrinhoCompras
 */
class Pessoa extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pessoas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome', 'telefone', 'nif', 'morada', 'codigo_postal', 'localidade'], 'required'],
            [['telefone', 'nif'], 'integer'],
            [['nome', 'morada', 'codigo_postal', 'localidade'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome',
            'telefone' => 'Telefone',
            'nif' => 'Nif',
            'morada' => 'Morada',
            'codigo_postal' => 'Codigo Postal',
            'localidade' => 'Localidade',
        ];
    }

    /**
     * Gets query for [[Artigo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArtigos()
    {
        return $this->hasMany(Artigo::class, ['pessoas_id' => 'id']);
    }

    /**
     * Gets query for [[Avaliacao]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAvaliacaos()
    {
        return $this->hasMany(Avaliacao::class, ['pessoas_id' => 'id']);
    }

    /**
     * Gets query for [[CarrinhoCompra]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCarrinhoCompras()
    {
        return $this->hasMany(CarrinhoCompra::class, ['pessoas_id' => 'id']);
    }
}
