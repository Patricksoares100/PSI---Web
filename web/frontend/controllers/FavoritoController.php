<?php

namespace frontend\controllers;

use Bluerhinos\phpMQTT;
use common\models\Favorito;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FavoritoController implements the CRUD actions for Favorito model.
 */
class FavoritoController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'only' => ['update', 'create', 'view','delete','index'],
                    'rules' => [
                        [
                            'actions' => ['view', 'create', 'index', 'delete'],
                            'allow' => true,
                            'roles' => ['permissionFrontoffice'],
                        ],
                    ],
                ],

                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Favorito models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $id = \Yii::$app->user->id;
        $dataProvider = new ActiveDataProvider([
            'query' => Favorito::find()->where(['perfil_id' => $id]), // So vai busar os favoritos apenas do utilizador que esta logado
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
            */
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Favorito model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Favorito model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($id)
    {
        $artigo_id = intval($id);
        $perfil_id = Yii::$app->user->id;

        $existeModel = Favorito::findOne(['artigo_id' => $artigo_id, 'perfil_id' => $perfil_id]);

        if ($existeModel) {
            $existeModel->delete();
            if ($existeModel->save()) {
                $this->publishFavoritoMessage("DELETEFAV", "Artigo removido dos favoritos", $existeModel->id);
                return $this->redirect(['index', 'id' => $existeModel->id]);
            }
        } else {
            $model = new Favorito();
            $model->artigo_id = intval($id);
            $model->perfil_id = Yii::$app->user->id;
            if ($model->save()) {
                $this->publishFavoritoMessage("INSERTFAV", "Artigo adicionado aos favoritos", $model->id);
                return $this->redirect(['index', 'id' => $model->id]);
            }

            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    /*if ($this->request->isPost) {
        if ($model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
    } else {
        $model->loadDefaultValues();
    }

    return $this->render('create', [
        'model' => $model,
    ]);*/


    /**
     * Updates an existing Favorito model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
  /*  public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if (Yii::$app->user->can('updateProprioCliente', ['perfil' => Yii::$app->user->id])) {
            if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }*/

    /**
     * Deletes an existing Favorito model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if (Yii::$app->user->can('deleteProprioCliente', ['perfil' => Yii::$app->user->id])) {
            $model->delete();
            $this->publishFavoritoMessage("DELETEFAV", "Artigo removido dos favoritos", $model->id);
            Yii::$app->session->setFlash('success', 'Artigo removido dos favoritos com sucesso.');
        } else {
            Yii::$app->session->setFlash('error', 'Você não tem permissão para remover este artigo dos favoritos.');
        }

        return $this->redirect(['index']);
    }

    protected function publishFavoritoMessage($canal, $mensagem, $favoritoId)
    {
        $model = Favorito::findOne($favoritoId);

        if ($model !== null) {
            $favoritoData = [
                'id' => $model->id,
                'artigo_id' => $model->artigo_id,
                'perfil_id' => $model->perfil_id,
                // add more fields as needed
            ];

            $message = [
                'canal' => $canal,
                'mensagem' => $mensagem,
                'favoritoObjeto' => $favoritoData,
            ];

            $this->fazPublishNoMosquitto($canal, json_encode($message));
        }
    }

    protected function fazPublishNoMosquitto($canal, $msg)
    {
        $server = "127.0.0.1";
        $port = 1883;
        $username = ""; // set your username
        $password = ""; // set your password
        $client_id = "phpMQTT-publisher"; // unique!
        $mqtt = new phpMQTT($server, $port, $client_id);
        if ($mqtt->connect(true, NULL, $username, $password)) {
            $mqtt->publish($canal, $msg, 0);
            $mqtt->close();
        } else {
            file_put_contents("debug.output", "Time out!");
        }
    }

    public function actionEnviarcarrinho($id, $idFav){
        Favorito::deleteAll(['id'=> $idFav]);
        return $this->redirect(['linhacarrinho/create',
            'id' => $id,
            ]);
    }

    //COLOCAR ESTA CONFIRMAÇÃO NO BOTAO DE REMOVER DOS FAVORITOS??????

    /*<?= Html::a('<i class="fa fa-times"></i>', ['/favorito/delete', 'id' => $model->id], [
        'class' => 'btn btn-sm btn-danger',
        'title' => 'Remover',
        'data' => [
            'confirm' => 'Tem certeza que deseja remover este item?',
            'method' => 'post',
        ],
    ]) ?>*/

    /**
     * Finds the Favorito model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Favorito the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected
    function findModel($id)
    {
        if (($model = Favorito::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
