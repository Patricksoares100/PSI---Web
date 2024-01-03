<?php

namespace backend\modules\api\controllers;

use common\models\LinhaCarrinho;
use Yii;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;

class CarrinhoController extends ActiveController
{
    public $modelClass = 'common\models\LinhaCarrinho';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::className(),
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

        // eliminar as function pre-definidas que possam haver
        unset($actions['index']);
        unset($actions['create']);


        return $actions;
    }

    public function actionIndex($id)
    {
        $response = [];
        $linhas = LinhaCarrinho::findAll(['perfil_id' => $id]);
        foreach ($linhas as $linha) {
            $data = [
                'carrinho' => [
                    'id' => $linha->id,
                    'quantidade' => $linha->quantidade,
                    'artigo' => [
                        //'id' => $linha->artigo->id,
                        'nome' => $linha->artigo->nome,
                        //'descricao' => $linha->artigo->descricao,
                        'preco' => $linha->artigo->preco,
                    ],
                ],
            ];
            $response[] = $data;
        }
        return $response;
    }

    public function actionCreate()
    {
        try {
            $params = Yii::$app->getRequest()->getBodyParams();
            // Verifica se todos os parâmetros necessários foram enviados
            if (!isset($params['quantidade']) || !isset($params['artigo_id']) || !isset($params['perfil_id'])) {
                throw new \Exception('Parâmetros inválidos');
            }
        } catch (\Exception $e) {
            return ["error" => $e->getMessage()];
        }

        $carrinho = LinhaCarrinho::findOne(['perfil_id' => $params['perfil_id'], 'artigo_id' => $params['artigo_id']]);
        if ($carrinho) {
            $carrinho->quantidade += 1; // Se já existe, incrementa a quantidade
            $carrinho->save();

            return ["response" => "Artigo adicionado ao Carrinho"];

        } else {
            $linhaNova = new LinhaCarrinho();
            $linhaNova->quantidade = $params['quantidade'];
            $linhaNova->artigo_id = $params['artigo_id'];
            $linhaNova->perfil_id = $params['perfil_id'];
            $linhaNova->save();

            return ["response" => "Artigo adicionado ao Carrinho"];
        }
    }
}
