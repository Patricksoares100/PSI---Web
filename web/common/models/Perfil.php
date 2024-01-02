<?php

namespace common\models;

use backend\models\AuthAssignment;
use Yii;
use yii\rbac\Item;

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
 *
 * @property Artigos[] $artigos
 * @property Avaliacaos[] $avaliacaos
 * @property Faturas[] $faturas
 * @property User $id0
 * @property LinhasCarrinho[] $linhasCarrinhos
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
            [['nome', 'telefone', 'nif', 'morada', 'codigo_postal', 'localidade'], 'required'],
            ['telefone', 'trim'],
            ['telefone', 'match', 'pattern' => '^\d{9}?$^', 'message' => 'Formato do telefone errado'],
            ['telefone', 'string', 'max' => 9, 'message' => 'Max 9 digitos'],

            ['nif', 'trim'],
            ['nif', 'unique', 'targetClass' => '\common\models\Perfil', 'message' => 'NIF já esta a ser utilizado.'],
            ['nif', 'match', 'pattern' => '^\d{9}?$^', 'message' => 'Formato do NIF errado'],
            ['nif', 'string', 'max' => 9, 'message' => 'Max 9 digitos'],
            [['nome', 'morada', 'localidade'], 'string', 'max' => 255],
            [['codigo_postal'], 'string', 'max' => 8, 'message' => 'NIF inválido'],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['id' => 'id']],
            ['codigo_postal', 'required'],
            ['codigo_postal', 'trim'],
            ['codigo_postal', 'match', 'pattern' => '^\d{4}-\d{3}?$^', 'message' => 'Insira o código postal neste formato: xxxx-xxx'],

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
    public function setNewRole($id){
        $auth = AuthAssignment::findOne(['user_id' => $id]);
        if($auth->item_name == 'Funcionario'){
            $auth->item_name = 'Cliente';
            $auth->save();
        }else{
            $auth->item_name = 'Funcionario';
            $auth->save();
        }
        return 1;
    }
    public function setNewStatus($id){
        $user = User::findOne($id);
        if($user->status == 10){
            $user->status = 9;
            $user->save();
        }else{
            $user->status = 10;
            $user->save();
        }
        return 1;
    }

    /**
     * Gets query for [[Faturas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFaturas()
    {
        return $this->hasMany(Faturas::class, ['perfil_id' => 'id']);
    }

    /**
     * Gets query for [[Id0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getId0()
    {
        return $this->hasOne(User::class, ['id' => 'id']);
    }

    public function getRole()
    {
        $auth = Yii::$app->authManager;
        $roles = $auth->getRolesByUser($this->id);
        $roleUser = "null";
        foreach ($roles as $role) {
            if ($role->type == 1)
                $roleUser = $role->name;
        }
        return $roleUser;
    }
    public function getStatusOptions()
    {

        return [
            'Ativo' => 'Ativo',
            'Inativo' => 'Inativo',
        ];
    }

    public function getEmail(){
        $user = User::findOne($this->id);
        return $user->email;
    }
    public function getUsername(){
        $user = User::findOne($this->id);
        return $user->username;
    }
    public function getPassword(){
        $user = User::findOne($this->id);
        return $user->password;
    }

    public function getStatus()
    {
        $user = User::findOne($this->id);
        if ($user->status == 10)
            return "Ativo";
        if ($user->status == 9)
            return "Inativo";
        else {
            return "Removido";
        }
    }
    public function getStatusNumber()
    {
        $user = User::findOne($this->id);
        return $user->status;
    }

    /**
     * Gets query for [[LinhasCarrinhos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhasCarrinhos()
    {
        return $this->hasMany(LinhasCarrinho::class, ['perfil_id' => 'id']);
    }

    public function apagarPerfilUser($id)
    {
    }

}
