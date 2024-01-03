<?php

namespace backend\modules\api\controllers;

use common\models\Artigo;
use common\models\Favorito;
use Yii;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;

class FavoritoController extends ActiveController
{
    public $modelClass = 'common\models\Favorito';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::className(),
            'except' => ['index', 'view', 'create', 'remove'], //Excluir aos GETs
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

    public function actionIndex()
    {
        $response = [];
        $favoritos = Favorito::find()->where(['perfil_id' => Yii::$app->params['id']])->all();

        foreach ($favoritos as $favorito) {

            $artigo = Artigo::find()->where(['id' => $favorito->artigo_id])->one();

            if ($artigo) {
                $images = $artigo->imagens;

                // Adiciona os detalhes do artigo diretamente ao array de resposta
                $data = [
                    'id' => $favorito->id,
                    'artigo' => $artigo,
                ];

                foreach ($images as $image) {
                    $image_binary = file_get_contents($image->image_path);

                    $data['imagens'] [] = base64_encode($image_binary);
                }
                $response[] = $data;
            }

        }
        return $response;
    }

    public function actionCreate()
    {
        try {
            $params = Yii::$app->getRequest()->getBodyParams();

            // Verifica se todos os parâmetros necessários foram enviados
            if (!isset($params['artigo_id'])) {
                throw new \Exception('Parâmetros inválidos');
            }

            // Verifica se o artigo já está nos favoritos do cliente
            $favorito = Favorito::findOne(['perfil_id' => Yii::$app->params['id'], 'artigo_id' => $params['artigo_id']]);
            if ($favorito) {
                throw new \Exception("Artigo já está nos favoritos");
            }

            // Cria uma nova instância de Favorito
            $favorito = new Favorito();
            $favorito->perfil_id = Yii::$app->params['id'];
            $favorito->artigo_id = $params['artigo_id'];
            $favorito->save();

            return ["response" => "Artigo adicionado aos favoritos"];
        } catch (\Exception $e) {
            return ["response" => $e->getMessage()];
        }
    }

    public function actionRemove()
    {
        $params = Yii::$app->request->post();
        $favorito = Favorito::findOne(['perfil_id' => Yii::$app->params['id'], 'artigo_id' => $params['artigo_id']]);
        if ($favorito) {
            $favorito->delete();
            return ["response" => "Produto removido dos favoritos"];
        }
        return ["response" => "Produto não existe nos favoritos"];
    }
}
