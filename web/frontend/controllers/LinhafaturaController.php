<?php

namespace frontend\controllers;

use common\models\Artigo;
use common\models\LinhaCarrinho;
use common\models\LinhaFatura;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LinhafaturaController implements the CRUD actions for LinhaFatura model.
 */
class LinhafaturaController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
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
     * Lists all LinhaFatura models.
     *
     * @return string
     */
    public function actionIndex($id)
    {
        $linhasCarrinho = LinhaCarrinho::find()->all();

        foreach ($linhasCarrinho as $linhaCarrinho) {
            $linhaFatura = new LinhaFatura();

            $linhaFatura->quantidade = $linhaCarrinho->quantidade;
            $linhaFatura->valor = $linhaCarrinho->quantidade * $linhaCarrinho->artigo->preco;
            $linhaFatura->valor_iva = $linhaCarrinho->quantidade * (($linhaCarrinho->artigo->iva->percentagem * $linhaCarrinho->artigo->preco) / 100);
            $linhaFatura->artigo_id = $linhaCarrinho->artigo_id;
            $linhaFatura->fatura_id = 1;

            if ($linhaFatura !== null) {
                $linhaFatura->save();
            } else {
                // Está-me a dar erro caso não atribua valor ao fatura_id. Supostamente como atribuo valor ao id da fatura se só fica com id depois de atribuída?
                print_r($linhaFatura->errors);
            }
        }

        $dataProvider = new ActiveDataProvider([
            'query' => LinhaFatura::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }



    /**
     * Displays a single LinhaFatura model.
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
     * Creates a new LinhaFatura model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($id)
    {
        $model = new LinhaFatura();

        $model->artigo_id = intval($id);
        $model->perfil_id = \Yii::$app->user->id;
        $model->quantidade = LinhaCarrinho::findOne($model->artigo_id);

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
     * Updates an existing LinhaFatura model.
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
     * Deletes an existing LinhaFatura model.
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
     * Finds the LinhaFatura model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return LinhaFatura the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LinhaFatura::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function getArtigo()
    {
        return $this->hasOne(Artigo::class, ['id' => 'artigo_id']);
    }
}
