<?php

namespace app\models;

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
 * @property Avaliacaos[] $avaliacaos
 * @property CarrinhoItems[] $carrinhoItems
 * @property Categorias $categorias
 * @property Fornecedores $fornecedores
 * @property Ivas $iva
 * @property Pessoas $pessoas
 */
class Artigos extends \yii\db\ActiveRecord
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
            [['categorias_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categorias::class, 'targetAttribute' => ['categorias_id' => 'id']],
            [['fornecedores_id'], 'exist', 'skipOnError' => true, 'targetClass' => Fornecedores::class, 'targetAttribute' => ['fornecedores_id' => 'id']],
            [['iva_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ivas::class, 'targetAttribute' => ['iva_id' => 'id']],
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
            'nome' => 'Nome',
            'descricao' => 'Descrição',
            'valor' => 'Preço Un.',
            'stock_atual' => 'Quantidade',
            'iva_id' => 'IVA',
            'fornecedores.nome' => 'Fornecedor',
            'fornecedores_id' => 'Fornecedor',
            'categorias.nome_categoria' => 'Categoria',
            'categorias_id' => 'Categoria',
            'pessoas_id' => 'Pessoas ID',
            'pessoas.nome' => 'Funcionário',
        ];
    }

    /**
     * Gets query for [[Avaliacaos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAvaliacaos()
    {
        return $this->hasMany(Avaliacaos::class, ['artigos_id' => 'id']);
    }

    /**
     * Gets query for [[CarrinhoItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCarrinhoItems()
    {
        return $this->hasMany(CarrinhoItems::class, ['artigos_id' => 'id']);
    }

    /**
     * Gets query for [[Categorias]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategorias()
    {
        return $this->hasOne(Categorias::class, ['id' => 'categorias_id']);
    }

    /**
     * Gets query for [[Fornecedores]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFornecedores()
    {
        return $this->hasOne(Fornecedores::class, ['id' => 'fornecedores_id']);
    }

    /**
     * Gets query for [[Iva]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIva()
    {
        return $this->hasOne(Ivas::class, ['id' => 'iva_id']);
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
