<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "artigos".
 *
 * @property int $id
 * @property string $nome
 * @property string $descricao
 * @property float $valor
 * @property int $stock_atual
 * @property int $iva_id
 * @property int $fornecedores_id
 * @property int $categorias_id
 * @property int $pessoas_id
 *
 * @property Avaliacao[] $avaliacaos
 * @property CarrinhoItem[] $carrinhoItems
 * @property Categoria $categorias
 * @property Fornecedor $fornecedores
 * @property Iva $iva
 * @property Pessoa $pessoas
 */
class Artigo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'artigos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome', 'descricao', 'valor', 'stock_atual', 'iva_id', 'fornecedores_id', 'categorias_id', 'pessoas_id'], 'required'],
            [['valor'], 'number'],
            [['stock_atual', 'iva_id', 'fornecedores_id', 'categorias_id', 'pessoas_id'], 'integer'],
            [['nome', 'descricao'], 'string', 'max' => 255],
            [['categorias_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categoria::class, 'targetAttribute' => ['categorias_id' => 'id']],
            [['fornecedores_id'], 'exist', 'skipOnError' => true, 'targetClass' => Fornecedor::class, 'targetAttribute' => ['fornecedores_id' => 'id']],
            [['iva_id'], 'exist', 'skipOnError' => true, 'targetClass' => Iva::class, 'targetAttribute' => ['iva_id' => 'id']],
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
            'nome' => 'Nome',
            'descricao' => 'Descrição',
            'valor' => 'Preço Un.',
            'stock_atual' => 'Quantidade',
            'iva_id' => 'IVA',
            'fornecedores.nome' => 'Fornecedor',
            'fornecedores_id' => 'Fornecedor',
            'categorias.nome_categoria' => 'Categoria',
            'categorias_id' => 'Categoria',
            'pessoas_id' => 'Pessoa ID',
            'pessoas.nome' => 'Funcionário',
        ];
    }

    /**
     * Gets query for [[Avaliacao]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAvaliacaos()
    {
        return $this->hasMany(Avaliacao::class, ['artigos_id' => 'id']);
    }

    /**
     * Gets query for [[CarrinhoItem]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCarrinhoItems()
    {
        return $this->hasMany(CarrinhoItem::class, ['artigos_id' => 'id']);
    }

    /**
     * Gets query for [[Categoria]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategorias()
    {
        return $this->hasOne(Categoria::class, ['id' => 'categorias_id']);
    }

    /**
     * Gets query for [[Fornecedor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFornecedores()
    {
        return $this->hasOne(Fornecedor::class, ['id' => 'fornecedores_id']);
    }

    /**
     * Gets query for [[Iva]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIva()
    {
        return $this->hasOne(Iva::class, ['id' => 'iva_id']);
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
