<?php

namespace backend\modules\api\controllers;
use common\models\LoginForm;
use common\models\Perfil;
use common\models\User;
use frontend\models\AlterarPasswordForm;
use frontend\models\SignupForm;
use yii\rest\ActiveController;
use yii\filters\auth\HttpBasicAuth;
use backend\models\AuthAssignment;
use Yii;

class UserController extends ActiveController
{
    public $modelClass = 'common\models\User';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::className(),
            'except' => ['registo'], //Excluir aos GETs
            'auth' => [$this, 'auth']
        ];
        return $behaviors;
    }
    public function auth($username, $password)
    {   //ppt8 slide 11
        $user = \common\models\User::findByUsername($username);
        if ($user && $user->validatePassword($password)) {

            return $user;
        }
        throw new \yii\web\ForbiddenHttpException('No authentication'); //403
    }
    public function actions()
    {
        $actions = parent::actions();
        //sem utilização
        unset($actions['index']);
        unset($actions['update']);
        unset($actions['delete']);
        unset($actions['view']);
        unset($actions['create']);
        return $actions;
    }
    /*nao interessa apagar no fim, fica ai só pra servir de ideia para outro controlador
     * public function actionCount()
    {
        //http://brindeszorro-back.test/api/users/count
        $model = new $this->modelClass;
        $count = $model::find()->all();
        return json_encode(['count' => count($count)]);
    }*/

    public function actionLogin(){
        //http://brindeszorro-back.test/api/users/login?username=cliente&password=teste123
        //ver se o user existe e validar password
        $form = new LoginForm();
        $form->load(Yii::$app->request->post(),'');
        $user = \common\models\User::findByUsername($form->username);
        $role = AuthAssignment::findOne(['user_id' => $user->id])->item_name;
        if ($role != "Cliente")
        {
            throw new \yii\web\ForbiddenHttpException("Acesso Negado");
        }else
        {
                $perfil = Perfil::findOne($user->id);
                 $responseArray = [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'nome' =>$perfil->nome ,
                'telefone' => $perfil->telefone ,
                'nif'=> $perfil->nif,
                'morada'=>$perfil->morada,
                'codigo_postal'=>$perfil->codigo_postal,
                'localidade'=>$perfil->localidade,
                'verification_token' => $user->verification_token,
            ];
            return json_encode($responseArray);
        }
        return ['response' => 'Username e/ou password incorreto.'];

    }
    public function actionRegisto(){
        //instanciar signupform
        //guardar os dados (os nomes na app tem q ser iguais ao do form
        //se sucesso retorna sucesso senao retona erro
        $model = new SignupForm();
        $model->load(Yii::$app->request->post(),'');
        if ($model->signup()) {
            return ["response" => "Registo com sucesso!"];
        }
        else{
            return ["response" => "Registo sem sucesso!"];

        }

    }

    public function actionAtualizarpassword($id){

        $form = new AlterarPasswordForm();
        $form->load(Yii::$app->request->post(),'');
       if($form->validate()) {
          if( $user = User::findOne(['id' => $id])){

              if(Yii::$app->security->validatePassword($form->atualPassword, $user->password_hash)){
                  $user->setPassword($form->novaPassword);
                  $user->save();
                  return ["response" => "Alterada com sucesso!"];
              }
              return ["response" => "Password errada!"];
          }
           return ["response" => "User não encontrado!"];
       }
        return ["response" => "Dados Incorretos!"];
    }

}
