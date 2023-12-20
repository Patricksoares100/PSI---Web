<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "faturas".
 *
 * @property int $id
 * @property DateTime $data
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
        return $this->hasMany(LinhasFatura::class, ['fatura_id' => 'id']);
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

// No modelo Fatura (common\models\Fatura)

    public function createFatura($iduser, $valorTotal)
    {
        $dataAtual = new \DateTime("now");
        $fatura = new Fatura();
        $fatura->data = $dataAtual->format('Y-m-d H:i:s');
        $fatura->valor_fatura = $valorTotal;
        $fatura->perfil_id = $iduser;
        $fatura->estado = 'Emitida';
        $fatura->save();

        return $fatura;
    }


    public function updateFatura($id)
    {
        $fatura = Fatura::findOne($id);
        $valorArtigosSiva = LinhaFatura::find()->sum('valor');
        $valorIva = LinhaFatura::find()->sum('valor_iva');
        $valorFatura = $valorArtigosSiva + $valorIva;
        $fatura->valor_fatura = $valorFatura;
        $fatura->save();

        return $fatura;
    }

    public function canDeleteFatura()
    {
        // ver se existe alguma fatura no estado EMITIDA
        $estadoFatura = $this->estado;

        if ($estadoFatura == 'Emitida') // Se existir, retorna true senao false
            return $estadoFatura ? true : false;
    }

    public static function getNumeroFaturasPagas()
    {
        return static::find()->andWhere(['estado' => 'Paga'])->count();
    }

    public static function getNumeroFaturasEmitidas()
    {
        return static::find()->andWhere(['Estado' => 'Emitida'])->count();
    }
}
