<?php

namespace frontend\controllers;

use common\models\LinhaCarrinho;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LinhacarrinhoController implements the CRUD actions for LinhaCarrinho model.
 */
class LinhacarrinhoController extends Controller
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
                    'only' => ['create','delete','index','update'], //tudo publico menos o q esta aqui, rotas afetadas pelo ACF
                    'rules' => [
                        [
                            'actions' => ['create', 'index','update','delete'],
                            'allow' => true,
                            'roles' => ['permissionFrontoffice'], // criar regra para apenas o propio
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
     * Lists all LinhaCarrinho models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $id = \Yii::$app->user->id;
        $dataProvider = new ActiveDataProvider([
            'query' => LinhaCarrinho::find()->where(['perfil_id' => $id]), // So vai busar as linhas do carrinho apenas do utilizador que esta logado
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
     * Displays a single LinhaCarrinho model.
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
     * Creates a new LinhaCarrinho model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($id)
    {
        $artigo_id = intval($id);
        $perfil_id = \Yii::$app->user->id;

        // Verifica se já existe uma linha com o mesmo artigo_id e perfil_id
        $existeModel = LinhaCarrinho::findOne(['artigo_id' => $artigo_id, 'perfil_id' => $perfil_id]);

        if ($existeModel) { // se encontrar uma linha com o mesmo artigo_id com o id logado
            $existeModel->quantidade += 1; // Se já existe, incrementa a quantidade
            if ($existeModel->save()) {
                return $this->redirect(['index', 'id' => $existeModel->id]);
            }
        } else { // aqui deixei igual, apenas coloquei a condição antes
            $model = new LinhaCarrinho();
            $model->quantidade = 1;
            $model->artigo_id = intval($id); // converte string to int em php
            $model->perfil_id = \Yii::$app->user->id;
            if ($model->save()) {
                return $this->redirect(['index', 'id' => $model->id]);
            }

            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing LinhaCarrinho model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $sinal)
    {
        $model = $this->findModel($id);
        if (Yii::$app->user->can('updateProprioCliente', ['perfil' => Yii::$app->user->id])) {
            if ($sinal == '+') {
                if ($model->quantidade < $model->artigo->stock_atual) { // seguindo a logica da linha faturas, aqui coloquei +1 para a quantidade do artigo na base de dados nao assumr valor negativo
                    $model->quantidade++;
                    Yii::$app->session->setFlash('success', 'Quantidade atualizada com sucesso!');
                } else {
                    Yii::$app->session->setFlash('error', 'Não temos em stock as quantidades de artigo que quer adicionar');
                }
            } else {
                $model->quantidade--;
                Yii::$app->session->setFlash('success', 'Quantidade atualizada com sucesso!');
                if ($model->quantidade <= 0) {
                    $this->findModel($id)->delete();
                    Yii::$app->session->setFlash('success', 'Artigo removido do carrinho com sucesso!');
                }
            }

            if ($this->request->isPost && $model->save()) {
                return $this->redirect(['index', 'id' => $model->id]);
            }
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing LinhaCarrinho model.
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
            Yii::$app->session->setFlash('success', 'Artigo removido com sucesso.');
        } else {
            Yii::$app->session->setFlash('error', 'Você não tem permissão para remover este artigo.');
        }

        return $this->redirect(['index']);
    }


    /**
     * Finds the LinhaCarrinho model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return LinhaCarrinho the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LinhaCarrinho::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
