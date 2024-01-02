<?php

namespace backend\modules\api\controllers;

use common\models\Artigo;
use common\models\Imagem;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;

class ArtigoController extends ActiveController
{
    public $modelClass = 'common\models\Artigo';

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

    public function actionIndex()
    {
        $response = [];
        $artigos = Artigo::find()->all();
        foreach ($artigos as $artigo) {
            $data = [
                'artigo' => $artigo,
                //PERGUNTAR AO PROF COMO BUSCAR A IMAGEM DOS ARTIGOS
                //'imagem' =>Imagem::findOne(['artigo_id' => $artigo->id])->image_path,
                ];
            $response[] = $data;
        }
        return $response;
    }
}
