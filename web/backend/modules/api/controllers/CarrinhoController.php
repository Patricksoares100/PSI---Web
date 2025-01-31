<?php

namespace backend\modules\api\controllers;

use common\models\Artigo;
use common\models\LinhaCarrinho;
use common\models\User;
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
            'except' => ['index', 'view', 'create', 'remove', 'adicionar', 'byuser', 'limparcarrinho', 'atualizar', 'limparlinhacarrinho'],
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

    public function actionByuser()
    {
        $response = [];
        $token = Yii::$app->request->get('token');
        $user = User::findByVerificationToken($token);
        $carrinhos = LinhaCarrinho::findAll(['perfil_id' => $user->id]);
        foreach ($carrinhos as $carrinho) {
            $imagem = $carrinho->artigo->getImg();

            $data = [
                'id' => $carrinho->id,
                'quantidade' => $carrinho->quantidade,
                'valorUnitario' => $carrinho->artigo->preco,
                'nome' => $carrinho->artigo->nome,
                'imagem' => 'http:172.22.21.219:8080/' . $imagem['image_path'],
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
        $artigo_id = $params['artigo_id'];
        $id = intval($artigo_id);
        $existeModel = LinhaCarrinho::findOne(['artigo_id' => $id, 'perfil_id' => $user->id]);
        if (!$existeModel) {
            $carrinho = new LinhaCarrinho();
            $carrinho->perfil_id = $user->id;
            $carrinho->artigo_id = $id;
            $quantidade = $params['quantidade'];
            $carrinho->quantidade = intval($quantidade);
            $carrinho->save();
            return "Artigo adicionado ao carrinho";
        } else {
            $artigo = Artigo::findOne(['id' => $id]);
            if ($artigo->stock_atual > $existeModel->quantidade){
                $existeModel->quantidade += 1;
                $existeModel->save();
                return "Artigo somado ao carrinho";
            } else {
                return "Stock insuficiente para adicionar à quantidade desejada";
            }
        }
    }

    public function actionLimparcarrinho()
    {

        $token = Yii::$app->request->get('token');
        $user = User::findByVerificationToken($token);
        $carrinhos = LinhaCarrinho::findAll(['perfil_id' => $user->id]);
        if ($carrinhos) {
            foreach ($carrinhos as $carrinho) {
                $carrinho->delete();
            }
            return "Carrinho limpo com sucesso!";
        } else {
            Yii::$app->response->statusCode = 401;
            return "Não há itens no carrinho para serem removidos!";
        }
    }
    public function actionLimparlinhacarrinho(){
        $token = Yii::$app->request->get('token');
        $id = Yii::$app->request->get('id');//id da linha do artigo
        $user = User::findByVerificationToken($token);
        $linha = LinhaCarrinho::findOne(['id' => $id, 'perfil_id' => $user->id]);
        $linha->delete();
        return "Artigo removido com sucesso!";
    }

    public function actionAtualizar()
    {
        $params = Yii::$app->getRequest()->getBodyParams();
        $token = Yii::$app->request->get('token');
        $user = User::findByVerificationToken($token);
        $id = $params['id']; //ID do carrinho
        $sinal = $params['sinal'];
        $id = intval($id);
        $existeModel = LinhaCarrinho::findOne(['id' => $id, 'perfil_id' => $user->id]);
        if ($existeModel) {
            if ($sinal == '+') {
                $artigo = Artigo::findOne(['id' => $existeModel->artigo_id]);
                if ($existeModel->quantidade < $artigo->stock_atual){
                    $existeModel->quantidade += 1;
                    $existeModel->save();
                    return "Quantidade adicionada com sucesso!";
                } else {
                    return "Não há stock disponivel!";
                }
            } else {
                $existeModel->quantidade--;
                if ($existeModel->quantidade == 0){
                    $existeModel->delete();
                    return "Artigo removido com sucesso!";
                }
                else {
                    $existeModel->save();
                    return "Quantidade removida com sucesso!";
                }
            }
        } else {
            Yii::$app->response->statusCode = 401;
            return "Não há itens no carrinho para serem editados!";
        }
    }

}
