<?php

namespace frontend\controllers;

use common\models\Artigo;
use common\models\Fatura;
use common\models\LinhaCarrinho;
use common\models\LinhaFatura;
use common\models\Perfil;
use Yii;
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
    public function actionIndex($iduser)
    {

        $dataProvider = new ActiveDataProvider([
            'query' => LinhaFatura::find($iduser),
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
    public function actionCreate($iduser)
    {
        $linhasCarrinho = LinhaCarrinho::find()->where(['perfil_id' => $iduser])->all();
        $valorSemIva = 0;
        $valorIva = 0;

        foreach ($linhasCarrinho as $linhaCarrinho) {
            $artigo = $linhaCarrinho->artigo;
            if ($linhaCarrinho->perfil_id == $iduser && $artigo) {
                $valorSemIva += $linhaCarrinho->quantidade * $artigo->preco;
                $valorIva += $linhaCarrinho->quantidade * (($artigo->iva->percentagem * $artigo->preco) / 100);
            }
        }
        // vai correr todas as linhas carrinho para depois as somar e somar ao valor total da datura
        $fatura = new Fatura();
        $fatura->data = (new \DateTime())->format('Y-m-d H:i:s');
        $fatura->valor_fatura = $valorSemIva + $valorIva;
        $fatura->perfil_id = $iduser;
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



            $artigo = Artigo::findOne($linhaCarrinho->artigo_id);
            $artigo->stock_atual -= $linhaCarrinho->quantidade;
            $artigo->save();

        }


        return $this->redirect(['fatura/view', 'id' => $faturaId, 'iduser' => $iduser]);
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
}