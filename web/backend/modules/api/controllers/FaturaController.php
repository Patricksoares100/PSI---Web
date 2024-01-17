<?php

namespace backend\modules\api\controllers;

use common\models\Artigo;
use common\models\Fatura;
use common\models\LinhaCarrinho;
use common\models\LinhaFatura;
use common\models\User;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;
use Yii;

class FaturaController extends ActiveController
{
    public $modelClass = 'common\models\Fatura';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::className(),
            'except' => ['index', 'view','find','detalhes','comprarcarrinho','pagar'], //Excluir aos GETs
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

    public function actionFind()
    {
        $response = [];
        $token = Yii::$app->request->get('token');
        $user = User::findByVerificationToken($token);
        $faturas = Fatura::findAll(['perfil_id' => $user->id]);
        foreach ($faturas as $fatura) {
            $data = [
                'id' => $fatura->id,
                'data' => $fatura->data,
                'valor_fatura' => $fatura->valor_fatura,
                'estado' => $fatura->estado,
                'perfil_id' => $fatura->perfil_id,
            ];
            $response[] = $data;
        }
        return $response;
    }

    public function actionPagar($id)
    {
        $fatura = Fatura::findOne($id);
        if (!$fatura) {
            return "Fatura não encontrada.";
        }

        $fatura->estado = "Paga";
        if ($fatura->save()) {
            return [
                'id' => $fatura->id,
                'data' => $fatura->data,
                'valor_fatura' => $fatura->valor_fatura,
                'estado' => $fatura->estado,
                'perfil_id' => $fatura->perfil_id,
            ];
        }
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

    public function actionComprarcarrinho()
    {

        $token = Yii::$app->request->get('token');
        $user = User::findByVerificationToken($token);
        $linhasCarrinho = LinhaCarrinho::findAll(['perfil_id' => $user->id]);
        $valorSemIva = 0;
        $valorIva = 0;
        if($linhasCarrinho){
            foreach ($linhasCarrinho as $linhaCarrinho) {
                $artigo = $linhaCarrinho->artigo;
                if ($linhaCarrinho->perfil_id == $user->id && $artigo) {
                    $valorSemIva += $linhaCarrinho->quantidade * $artigo->preco;
                    $valorIva += $linhaCarrinho->quantidade * (($artigo->iva->percentagem * $artigo->preco) / 100);
                }
            }
            $artigo = Artigo::findOne($linhaCarrinho->artigo_id);
            if ($artigo->stock_atual >= $linhaCarrinho->quantidade){
                $artigo->stock_atual -= $linhaCarrinho->quantidade;
                $artigo->save();

                // vai correr todas as linhas carrinho para depois as somar e somar ao valor total da datura
                $fatura = new Fatura();
                $fatura->data = (new \DateTime())->format('Y-m-d H:i:s');
                $fatura->valor_fatura = $valorSemIva + $valorIva;
                $fatura->perfil_id = $user->id;
                $fatura->estado = 'Emitida';
                $fatura->save();

                $faturaId = $fatura->id;
                // aqui depois de criar a fatura vai crar as linhas
                foreach ($linhasCarrinho as $linhaCarrinho) {
                    $linhaFatura = new LinhaFatura();
                    $linhaFatura->quantidade = $linhaCarrinho->quantidade;
                    $linhaFatura->valor = number_format(($linhaCarrinho->quantidade * $linhaCarrinho->artigo->preco), 2);
                    $linhaFatura->valor_iva = number_format($linhaCarrinho->quantidade * (($linhaCarrinho->artigo->iva->percentagem * $linhaCarrinho->artigo->preco) / 100), 2);
                    $linhaFatura->artigo_id = $linhaCarrinho->artigo_id;
                    $linhaFatura->fatura_id = $faturaId;
                    $linhaFatura->save();

                }
                LinhaCarrinho::deleteAll(['perfil_id' => $user->id]);
            }
            //realizar fatura
            //return "Compra com sucesso!";//dar return só dos dados necessarios
            return [
                'fatura_id' => $faturaId,
                'data' => $fatura->data,
                'valor_fatura' => $fatura->valor_fatura,
                'estado' => $fatura->estado,
                'perfil_id' => $fatura->perfil_id,

            ];

        }else{
            Yii::$app->response->statusCode = 401;
            return "Não há itens no carrinho para efetuar compra!";
        }


    }

}
