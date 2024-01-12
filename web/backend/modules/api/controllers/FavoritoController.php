<?php

namespace backend\modules\api\controllers;

use common\models\Artigo;
use common\models\Favorito;
use common\models\User;
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
            'except' => ['index', 'view', 'create', 'remove','byuser', 'adicionar'], //Excluir aos GETs
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

        // Se quisermos apagar açoes para o controlador nao as suportar
        // apagamos o index e o create para fazer uma implementaçao personalizada
        unset($actions['index']);
        unset($actions['create']);
        unset($actions['delete']);
        unset($actions['user']);

        return $actions;
    }

    public function actionByuser()
    {
        $response = [];
        $token = Yii::$app->request->get('token');
        $user = User::findByVerificationToken($token);
        $favoritos = Favorito::findAll(['perfil_id' => $user->id]);
        foreach ($favoritos as $favorito) {

            $data = [
                        'id' => $favorito->id,
                        'artigo_id' => $favorito->artigo_id,
                        'perfil_id' => $favorito->perfil_id,
                        'valorArtigo' => $favorito->artigo->preco,
                        'nomeArtigo' => $favorito->artigo->nome,
            ];
                $response[] = $data;

        }
        return $response;
    }

    public function actionAdicionar()
    {
        $params = Yii::$app->getRequest()->getBodyParams();
        $token = Yii::$app->request->get('token');
        $user = User::findByVerificationToken($token);
        $id = $params['artigo_id'];
        $id = intval($id);


        $existeModel = Favorito::findOne(['artigo_id' => $id, 'perfil_id' => $user->id]);


        if (!$existeModel) {
            $favorito = new Favorito();

            $favorito->perfil_id = $user->id;
            $favorito->artigo_id = $id;
            $favorito->save();

            return ["response" => "Artigo adicionado aos favoritos"];
        } else {
            return ["error" => "Artigo já está nos favoritos!"];
        }
    }


    public function actionRemove()
    {
        try {
            $params = Yii::$app->getRequest()->getBodyParams();
            // Verifica se todos os parâmetros necessários foram enviados
            if (!isset($params['artigo_id'])) {
                throw new \Exception('Parâmetros inválidos');
            }

        } catch (\Exception $e) {
            return ["error" => $e->getMessage()];
        }

        $params = Yii::$app->request->post();
        $favorito = Favorito::findOne(['perfil_id' => $params['perfil_id'], 'artigo_id' => $params['artigo_id']]);
        if ($favorito) {
            $favorito->delete();
            return ["response" => "Produto removido dos favoritos"];
        } else {
            return ["response" => "Produto não existe nos favoritos"];
        }
    }
}
