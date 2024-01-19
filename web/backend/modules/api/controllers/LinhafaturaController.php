<?php

namespace backend\modules\api\controllers;

use common\models\Artigo;
use common\models\LinhaFatura;
use common\models\User;
use Yii;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;

class LinhafaturaController extends ActiveController
{
    public $modelClass = 'common\models\LinhaFatura';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::className(),
            'except' => ['index', 'create', 'limparlinhasfatura', 'atualizar'],
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

    public function actionIndex()
    {
        $fatura_id = Yii::$app->request->get('id');
        $response = [];
        $linhas = LinhaFatura::findAll(['fatura_id' => $fatura_id]);
        foreach ($linhas as $linha) {
            $artigo = Artigo::findOne($linha->artigo_id);
            $imagem = $artigo->getImg();
            $data = [
                    'id' => $linha->id,
                    'quantidade' => $linha->quantidade,
                    'valorTotal' => $linha->valor,
                    'valor_iva' => $linha->valor_iva,
                    'nome' => $linha->artigo->nome,
                    'precoUnitario' => $linha->artigo->preco,
                    'imagem' => 'http:172.22.21.219:8080/' . $imagem['image_path'],
            ];
            $response[] = $data;
        }
        return $response;
    }

    public function actionCreate()
    {
        $token = Yii::$app->request->get('token');
        $user = User::findByVerificationToken($token);

        $linha = new LinhaFatura();
        $linha->load(Yii::$app->request->post(), '');
        /*$linha->quantidade = $params['quantidade'];   TODOS OS VALORES COMENTADOS, VEM NO FORM, DEPOIS NO ANDROID/SINGLETON PUXAR ESTES PARAMETROS COMENTADOS
        $linha->valor = $params['valor'];
        $linha->valor_iva = $params['valor_iva'];
        $linha->artigo_id = $params['artigo_id'];*/
        $linha->fatura->perfil_id = $user->id;
        $linha->save();

        return "Linha da fatura adicionada à Fatura!";
    }

    public function actionLimparlinhasfatura()
    {
        $id = Yii::$app->request->get('id');
        $linhas = LinhaFatura::findOne(['id' => $id]);

        if ($linhas) {
            $linhas->delete();
            return "Linhas faturas limpas com sucesso!";
        } else {
            return "Não há linhas fatura para serem removidas!";
        }
    }

    public function actionAtualizar()
    {
        $id = Yii::$app->request->get('id');
        $linha = LinhaFatura::findOne(['id' => $id]);

        if ($linha != null){
            $linha->load(Yii::$app->request->post(), '');
            $linha->save();

            return "Linha da fatura editada com sucesso!";
        }
        return "Linha da fatura não pode ser editada!";
    }
}
