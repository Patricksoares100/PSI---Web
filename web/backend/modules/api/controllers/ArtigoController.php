<?php

namespace backend\modules\api\controllers;

use common\models\Artigo;
use common\models\Avaliacao;
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
            'except' => ['index', 'view','create'], //Excluir aos GETs
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


    /*public function actionIndex()
    {
        $response = [];
        $artigos = Artigo::find()->all();
        foreach ($artigos as $artigo) {
            $images = $artigo->imagens;
            $data = [
                'artigo' => $artigo,
                //PERGUNTAR AO PROF COMO BUSCAR A IMAGEM DOS ARTIGOS
                //'imagem' =>Imagem::findOne(['artigo_id' => $artigo->id])->image_path,
            ];
            foreach ($images as $image)
            {
                $image_binary = file_get_contents( $image->image_path );

                $data['imagens'] [] = base64_encode($image_binary);
            }
            $response[] = $data;
        }
        return $response;
    }*/
    public function actionIndex()
    {
        $response = [];
        $artigos = Artigo::find()->all();
        foreach ($artigos as $artigo) {
            $imagem = $artigo->getImg();
            $data = [
                'id' => $artigo->id,
                'nome' => $artigo->nome,
                'descricao' => $artigo->descricao,
                'referencia' => $artigo->referencia,
                'preco' => $artigo->preco,
                'stock_atual' => $artigo->stock_atual,
                'iva' => $artigo->iva->percentagem,
                'fornecedor' => $artigo->fornecedor->nome,
                'categoria' => $artigo->categoria->nome,
                'media_avaliacoes' => Avaliacao::getMediaAvaliacoes($artigo->id),
                'num_avaliacoes' => Avaliacao::getNumAvaliacoes($artigo->id),
                //'perfil' => $artigo->perfil->nome, não interessa saber isso na app
                'imagem' => 'http:172.22.21.219:8080/' . $imagem['image_path'],
                //'imagem' =>  $artigo->getImg(),

            ];
            $response[] = $data;
        }
        return $response;
    }
}
