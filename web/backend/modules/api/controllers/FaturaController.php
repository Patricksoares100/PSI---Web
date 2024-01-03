<?php

namespace backend\modules\api\controllers;

use common\models\Artigo;
use common\models\Empresa;
use common\models\Fatura;
use common\models\LinhaFatura;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;

class FaturaController extends ActiveController
{
    public $modelClass = 'common\models\Fatura';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::className(),
            //'except' => ['index', 'view'], //Excluir aos GETs
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

        // disable the "delete" and "create" actions
        unset($actions['find']);


        return $actions;
    }

    public function actionFind($id)
    {
        $response = [];
        $faturas = Fatura::findAll(['perfil_id' => $id]);
        foreach ($faturas as $fatura) {
            $data = [
                'fatura' => $fatura,
            ];
            $response[] = $data;
        }
        return $response;
    }

    public function actionDetalhes($id)
    {
        $response = [];
        $faturas = Fatura::findAll(['perfil_id' => $id]);

        foreach ($faturas as $fatura) {
            $linhasFatura = LinhaFatura::find()->where(['fatura_id' => $fatura->id])->all();
            $artigos=[];
            foreach ($linhasFatura as $linhaFatura) {
                $artigo = Artigo::findOne($linhaFatura->artigo_id);
                $artigos[] = $artigo;
            }

            $data = [
                'fatura' => $fatura,
                'linhasFaturas' => $linhasFatura,
                'artigos' => $artigos,
            ];

            $response[] = $data;
        }

        return $response;
    }



}
