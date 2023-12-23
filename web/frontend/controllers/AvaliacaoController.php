<?php

namespace frontend\controllers;

use common\models\Artigo;
use common\models\Avaliacao;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AvaliacaoController implements the CRUD actions for Avaliacao model.
 */
class AvaliacaoController extends Controller
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
                    'only' => ['update', 'create','view','delete','index'], //tudo publico menos o q esta aqui, rotas afetadas pelo ACF
                    'rules' => [
                        [
                            'actions' => ['view', 'create', 'index'],
                            'allow' => true,
                            'roles' => ['permissionFrontoffice'], // criar regra para apenas o propio
                        ],
                        [
                            'actions' => ['update'],
                            'allow' => true,
                            'roles' => ['updateProprioCliente'],
                        ],
                        [
                            'actions' => ['delete'],
                            'allow' => true,
                            'roles' => ['deleteProprioCliente'],
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
     * Lists all Avaliacao models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Avaliacao::find()->where(['perfil_id' => Yii::$app->user->id]),
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
     * Displays a single Avaliacao model.
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
     * Creates a new Avaliacao model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($id)
    {
        $idUser = Yii::$app->user->id;
        $artigo = Artigo::findOne($id);
        $model = new Avaliacao();
        $model->perfil_id = $idUser;
        $model->artigo_id = $id;


        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->validate() && $model->save()) {
                return $this->redirect(['artigo/detail', 'id' => $artigo->id]);
            }
        } else {
            $model->loadDefaultValues();

        }

        return $this->render('create', [
            'model' => $model,
            'id' => $id,
        ]);
    }


    /**
     * Updates an existing Avaliacao model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Avaliacao model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Avaliacao model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Avaliacao the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Avaliacao::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
