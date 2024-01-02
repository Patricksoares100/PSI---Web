<?php

namespace backend\modules\api\controllers;

use common\models\Perfil;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;
use Yii;

class PerfilController extends ActiveController
{
    public $modelClass = 'common\models\Perfil';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::className(),
            //'except' => ['index', 'view','atualizar'], //Excluir aos GETs
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

    public function  actionAtualizar($id)
    {
        $model =  Perfil::findOne(['id' => $id]);
        if($model->load(Yii::$app->getRequest()->getBodyParams(),'')) {

            if($model->save()) {
                return $model;
            }
            else {
                $errors = [];
                foreach ($model->errors as $attributeErrors) {
                    foreach ($attributeErrors as $error) {
                        $errors[] = $error;
                    }
                }
                return ["response" => $errors];
            }
        }
        return $model;
    }
}
