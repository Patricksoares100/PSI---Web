<?php

namespace backend\modules\api\controllers;
use frontend\models\SignupForm;
use yii\rest\ActiveController;
use yii\filters\auth\HttpBasicAuth;
use backend\models\AuthAssignment;

class UserController extends ActiveController
{
    public $modelClass = 'common\models\User';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::className(),
            'except' => ['index', 'view'], //Excluir aos GETs
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
    /*nao interessa apagar no fim, fica ai só pra servir de ideia para outro controlador
     * public function actionCount()
    {
        //http://brindeszorro-back.test/api/users/count
        $model = new $this->modelClass;
        $count = $model::find()->all();
        return json_encode(['count' => count($count)]);
    }*/

    public function actionLogin($username, $password){
        //http://brindeszorro-back.test/api/users/login?username=cliente&password=teste123
        //ver se o user existe e validar password
        $user = \common\models\User::findByUsername($username);
        if ($user && $user->validatePassword($password))
        {
           /* $role = AuthAssignment::findOne(['user_id' => user->id])->item_name;
            if ($role != "Cliente") {
                throw new \yii\web\ForbiddenHttpException("Acesso Negado, entre como cliente!");
            }
            else{*/
                $responseArray = [
                    'id' => $user->id,
                    'username' => $user->username,
                    'auth_key' => $user->auth_key,
                    'password_hash' => $user->password_hash,
                    'password_reset_token' => $user->password_reset_token,
                    'email' => $user->email,
                    //'status' => $user->status,
                    //'created_at' => $user->created_at,
                    //'updated_at' => $user->updated_at,
                    'verification_token' => $user->verification_token,
                ];
                return json_encode($responseArray);
           // }
        }
        throw new \yii\web\ForbiddenHttpException('No authentication'); //403

    }
    public function actionRegisto(){
        //instanciar signupform
        //guardar os dados (os nomes na app tem q ser iguais ao do form
        //se sucesso retorna sucesso senao retona erro
        $model = new SignupForm();
        $model->load(Yii::$app->request->post());
        if ($model->signup()) {
            return json_encode(["response" => "Registo com sucesso!"]);
        }

    }

}
