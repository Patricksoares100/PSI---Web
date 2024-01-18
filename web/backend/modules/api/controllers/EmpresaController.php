<?php

namespace backend\modules\api\controllers;

use common\models\Empresa;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;

class EmpresaController extends ActiveController
{
    public $modelClass = 'common\models\Empresa';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::className(),
            'except' => ['find'], //Excluir aos GETs
            'auth' => [$this, 'auth']
        ];
        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();

        // Se quisermos apagar açoes para o controlador nao as suportar
        // disable the "delete" and "create" actions
        //unset($actions['delete'], $actions['create']);

        // apagamos o index para fazer uma implementaçao personalizada
        unset($actions['index']);

        return $actions;
    }



    public function actionFind()
    {
        $faturas = Empresa::find()->one();
        return $faturas;
    }
}
