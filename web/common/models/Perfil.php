<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "perfis".
 *
 * @property int $id
 * @property string $nome
 * @property int $telefone
 * @property int $nif
 * @property string $morada
 * @property string $codigo_postal
 * @property string $localidade
 * @property int $carrinho_id
 *
 * @property Artigo[] $artigos
 * @property Avaliacao[] $avaliacaos
 * @property Carrinho $carrinho
 * @property Fatura[] $faturas
 */
class Perfil extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'perfis';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome', 'telefone', 'nif', 'morada', 'codigo_postal', 'localidade', 'carrinho_id'], 'required'],
            [['telefone', 'nif', 'carrinho_id'], 'integer'],
            [['nome', 'morada', 'codigo_postal', 'localidade'], 'string', 'max' => 255],
            [['carrinho_id'], 'exist', 'skipOnError' => true, 'targetClass' => Carrinho::class, 'targetAttribute' => ['carrinho_id' => 'id']],
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
            'nif' => 'NIF',
            'morada' => 'Morada',
            'codigo_postal' => 'Código Postal',
            'localidade' => 'Localidade',
            'carrinho_id' => 'Nº do Carrinho',
        ];
    }

    /**
     * Gets query for [[Artigos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArtigos()
    {
        return $this->hasMany(Artigo::class, ['perfil_id' => 'id']);
    }

    /**
     * Gets query for [[Avaliacaos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAvaliacaos()
    {
        return $this->hasMany(Avaliacao::class, ['perfil_id' => 'id']);
    }

    /**
     * Gets query for [[Carrinho]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCarrinho()
    {
        return $this->hasOne(Carrinho::class, ['id' => 'carrinho_id']);
    }

    /**
     * Gets query for [[Faturas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFaturas()
    {
        return $this->hasMany(Fatura::class, ['perfil_id' => 'id']);
    }
}
