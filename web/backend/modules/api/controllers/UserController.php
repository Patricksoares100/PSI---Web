<?php

namespace backend\modules\api\controllers;
use yii\rest\ActiveController;
use yii\filters\auth\HttpBasicAuth;

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
    {
        $user = \common\models\User::findByUsername($username);
        if ($user && $user->validatePassword($password)) {
            return $user;
        }
        throw new \yii\web\ForbiddenHttpException('No authentication'); //403
    }
    public function actionCount()
    {
        $model = new $this->modelClass;
        $count = $model::find()->all();
        return json_encode(['count' => count($count)]);
    }

    public function actionUser($username, $password)
    {
        $user = \common\models\User::findByUsername($username);
        if ($user && $user->validatePassword($password)) {
            $responseArray = [
                //'id' => $user->id,
                'username' => $user->username,
                //'auth_key' => $user->auth_key,
                'password_hash' => $user->password_hash,
                //'password_reset_token' => $user->password_reset_token,
                'email' => $user->email,
                //'status' => $user->status,
                //'created_at' => $user->created_at,
                //'updated_at' => $user->updated_at,
                //'verification_token' => $user->verification_token,
            ];
            return json_encode($responseArray);
        }
        throw new \yii\web\ForbiddenHttpException('No authentication'); //403
    }

}
