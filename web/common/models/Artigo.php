<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "artigos".
 *
 * @property int $id
 * @property string $nome
 * @property string $descricao
 * @property string $referencia
 * @property float $preco
 * @property int $stock_atual
 * @property int $iva_id
 * @property int $fornecedor_id
 * @property int $categoria_id
 * @property int $perfil_id
 *
 * @property Avaliacao[] $avaliacaos
 * @property Categoria $categoria
 * @property Fornecedore $fornecedor
 * @property Iva $iva
 * @property LinhasCarrinho[] $linhasCarrinhos
 * @property LinhasFatura[] $linhasFaturas
 * @property Perfi $perfil
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
            [['nome', 'descricao', 'referencia', 'preco', 'stock_atual', 'iva_id', 'fornecedor_id', 'categoria_id', 'perfil_id'], 'required'],
            [['preco'], 'number'],
            [['stock_atual', 'iva_id', 'fornecedor_id', 'categoria_id', 'perfil_id'], 'integer'],
            [['nome', 'descricao', 'referencia'], 'string', 'max' => 255],
            [['categoria_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categoria::class, 'targetAttribute' => ['categoria_id' => 'id']],
            [['fornecedor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Fornecedore::class, 'targetAttribute' => ['fornecedor_id' => 'id']],
            [['iva_id'], 'exist', 'skipOnError' => true, 'targetClass' => Iva::class, 'targetAttribute' => ['iva_id' => 'id']],
            [['perfil_id'], 'exist', 'skipOnError' => true, 'targetClass' => Perfi::class, 'targetAttribute' => ['perfil_id' => 'id']],
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
            'descricao' => 'Descricao',
            'referencia' => 'Referencia',
            'preco' => 'Preco',
            'stock_atual' => 'Stock Atual',
            'iva_id' => 'Iva ID',
            'fornecedor_id' => 'Fornecedor ID',
            'categoria_id' => 'Categoria ID',
            'perfil_id' => 'Perfil ID',
        ];
    }

    /**
     * Gets query for [[Avaliacaos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAvaliacaos()
    {
        return $this->hasMany(Avaliacao::class, ['artigo_id' => 'id']);
    }

    /**
     * Gets query for [[Categoria]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategoria()
    {
        return $this->hasOne(Categoria::class, ['id' => 'categoria_id']);
    }

    /**
     * Gets query for [[Fornecedor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFornecedor()
    {
        return $this->hasOne(Fornecedore::class, ['id' => 'fornecedor_id']);
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
     * Gets query for [[LinhasCarrinhos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhasCarrinhos()
    {
        return $this->hasMany(LinhasCarrinho::class, ['artigo_id' => 'id']);
    }

    /**
     * Gets query for [[LinhasFaturas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhasFaturas()
    {
        return $this->hasMany(LinhasFatura::class, ['artigo_id' => 'id']);
    }

    /**
     * Gets query for [[Perfil]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPerfil()
    {
        return $this->hasOne(Perfi::class, ['id' => 'perfil_id']);
    }
}
