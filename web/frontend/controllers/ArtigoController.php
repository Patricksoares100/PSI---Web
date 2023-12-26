<?php

namespace frontend\controllers;

use common\models\Artigo;
use app\models\ArtigoSearch;
use common\models\Avaliacao;
use common\models\Imagem;
use common\models\LinhaCarrinho;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


/**
 * ArtigoController implements the CRUD actions for Artigos model.
 */
class ArtigoController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                // Metemos aqui tudo publico?
                'access' => [
                    'class' => AccessControl::class,
                    'only' => ['create', 'update', 'delete', 'view', 'index', 'detail', 'adicionarcarrinho'], //tudo publico menos o q esta aqui, rotas afetadas pelo ACF
                    'rules' => [
                        [
                            'actions' => ['create', 'update', 'delete', 'view', 'adicionarcarrinho'],
                            'allow' => false,
                            'roles' => ['permissionFrontoffice', '?', '@'], // qualquer utilizador do FrontOffice
                        ],
                        [
                            'actions' => ['index', 'detail'],
                            'allow' => true,
                            'roles' => ['permissionFrontoffice', '?', '@'], // qualquer utilizador do FrontOffice
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
     * Lists all Artigos models.
     *
     * @return string
     */

    public function actionIndex()
    {
        $searchModel = new ArtigoSearch();

        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCategorias($id)
    {
        $searchModel = new ArtigoSearch();

        if ($id != null) {
            $searchModel->categoria_id = $id;
        }

        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Artigos model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('artigo');
        /*return $this->render('view', [
            'model' => $this->findModel($id),
        ]);*/
    }

    /**
     * Creates a new Artigos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Artigo();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Artigos model.
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
     * Deletes an existing Artigos model.
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
     * Finds the Artigos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Artigos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Artigo::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionDetail($id, $quantidade = 1)
    {
        $model = $this->findModel($id);

        return $this->render('detail', [
            'model' => $model,
            'avaliacoes' => Avaliacao::findAll(['artigo_id' => $model->id]),
            'avaliacao' => new Avaliacao (),
            'id' => $id,
            'numeroImagens' => Imagem::find()->where(['artigo_id' => $id])->count(),
            'quantidade' => $quantidade,
        ]);
    }

    public function actionAdicionarcarrinho($id, $quantidade, $sinal)
    {
        $quantidade = intval($quantidade);
        $model = $this->findModel($id);
        if ($sinal == '+') {
            if ($quantidade < $model->stock_atual) {
                $quantidade++;
                Yii::$app->session->setFlash('success', 'Quantidade adicionada com sucesso!');
            } else {
                Yii::$app->session->setFlash('error', 'Não temos em stock as quantidades de artigo que quer adicionar');
            }

        } else {
            $quantidade--;
            if ($quantidade <= 0) {
                Yii::$app->session->setFlash('error', 'Quantidade não pode ser inferior ou igual a 0');
                $quantidade = 1;
            } else {

                Yii::$app->session->setFlash('success', 'Quantidade removida com sucesso!');
            }
        }
        return $this->redirect(['detail',
            'id' => $model->id,
            'quantidade' => $quantidade,
        ]);
    }

}
