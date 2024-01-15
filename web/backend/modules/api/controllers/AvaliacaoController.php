<?php

namespace backend\modules\api\controllers;

use common\models\Avaliacao;
use common\models\User;
use yii\filters\auth\HttpBasicAuth;
use Yii;
use yii\rest\ActiveController;

class AvaliacaoController extends ActiveController
{
    public $modelClass = 'common\models\Avaliacao';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::className(),
            'except' => ['index', 'view','atualizar','criar','byuser'], //Excluir aos GETs
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

    public function actionByuser()
    {
        $response = [];
        $token = Yii::$app->request->get('token');
        $user = User::findByVerificationToken($token);
        $avaliacaos = Avaliacao::findAll(['perfil_id' => $user->id]);
        foreach ($avaliacaos as $avaliacao) {
            $imagem = $avaliacao->artigo->getImg();

            $data = [
                'id' => $avaliacao->id,
                'artigo_id' => $avaliacao->artigo_id,
                'perfil_id' => $avaliacao->perfil_id,
               // 'valorArtigo' => $avaliacao->artigo->preco,
                'comentario' => $avaliacao->comentario,
                'classificacao' => $avaliacao->classificacao,
                'nomeArtigo' => $avaliacao->artigo->nome,
                'imagem' => 'http:172.22.21.219:8080/' . $imagem['image_path'],
            ];
            $response[] = $data;

        }
        return $response;
    }

   /* public function actions()
    {
        $actions = parent::actions();
        //sem utilização
        unset($actions['index']);
        unset($actions['update']);
        unset($actions['delete']);
        unset($actions['view']);
        unset($actions['create']);
        return $actions;
    }*/

    public function actionVer(){
    //fica assim pra já pq nao temos nem ver nem editar avaliacao no android
        ///e nao vamos perder tempo nisso pra já
    }

    public function actionCriar(){
        $model = new Avaliacao();
        $model->load(Yii::$app->request->post(),'');
        if($model->validate()){
            $model->save();
            return ["response" => "Avaliação registada com sucesso!"];
        }else{
            return ["response" => "Preencha todos os campos!"];

        }

    }

}
