<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "faturas".
 *
 * @property int $id
 * @property string $data
 * @property float $valor_fatura
 * @property string|null $estado
 * @property int $perfil_id
 *
 * @property LinhasFaturas[] $linhasFaturas
 * @property Perfis $perfil
 */
class Fatura extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'faturas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['data', 'valor_fatura', 'perfil_id'], 'required'],
            [['data'], 'safe'],
            [['valor_fatura'], 'number'],
            [['estado'], 'string'],
            [['perfil_id'], 'integer'],
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
            'data' => 'Data',
            'valor_fatura' => 'Valor Fatura',
            'estado' => 'Estado',
            'perfil_id' => 'Perfil ID',
        ];
    }

    /**
     * Gets query for [[LinhasFaturas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhasFaturas()
    {
        return $this->hasMany(LinhasFaturas::class, ['fatura_id' => 'id']);
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

    public function canDeleteFatura()
    {
        // ver se existe alguma fatura no estado EMITIDA
        $estadoFatura = $this->estado;

        if ($estadoFatura == 'Emitida') // Se existir, retorna true senao false
            return $estadoFatura ? true : false;
    }
}
