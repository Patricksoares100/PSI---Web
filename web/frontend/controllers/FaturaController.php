<?php

namespace frontend\controllers;

use Bluerhinos\phpMQTT;
use common\models\Empresa;
use common\models\Fatura;
use common\models\LinhaFatura;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FaturaController implements the CRUD actions for Fatura model.
 */
class FaturaController extends Controller
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
                    'only' => ['update', 'view', 'delete', 'pagar', 'index', 'imprimir'],
                    'rules' => [
                        [
                            'actions' => ['view', 'index', 'pagar', 'delete', 'imprimir'],
                            'allow' => true,
                            'roles' => ['permissionFrontoffice'],//tbm só deve apagar as do propio, fazer rule!
                        ],

                    ],
                ],

               /* 'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],*/
            ]
        );
    }

    /**
     * Lists all Fatura models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Fatura::find()->where(['perfil_id' => Yii::$app->user->id]),
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Fatura model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if (Yii::$app->user->can('updateProprioCliente', ['perfil' => Yii::$app->user->id])) {
            $model = $this->findModel($id);
            if ($model->perfil_id == Yii::$app->user->id) {
                // Construir array associativo com os detalhes da fatura
                $faturaDetalhes = [
                    'id' => $model->id,
                    'data' => $model->data,
                    'valor_fatura' => $model->valor_fatura,
                    'estado' => $model->estado,
                    'perfil_id' => $model->perfil_id,
                    // Adicione outros campos conforme necessário
                ];

                // Converter array associativo para JSON
                $mensagemJSON = json_encode($faturaDetalhes, JSON_PRETTY_PRINT);

                // MQTT Publish
                $mqtt = new phpMQTT('localhost', 1883, 'ClientId'); // Certifique-se de ajustar os detalhes da conexão MQTT
                if ($mqtt->connect()) {
                    $mqtt->publish('FATURAVIEW', $mensagemJSON, 1);
                    $mqtt->close();
                } else {
                    Yii::error('Falha ao conectar ao servidor MQTT.');
                }
                return $this->render('view', [
                    'model' => $model,
                    'empresa' => Empresa::find()->one(),
                    'linhasFaturas' => LinhaFatura::find()->where(['fatura_id' => $id])->all(),

                ]);
            } else {
                Yii::$app->session->setFlash('error', 'Não tem permissões para visualizar uma fatura de outro cliente!');
            }
        } else {
            Yii::$app->session->setFlash('error', 'Não tem permissões para visualizar uma fatura de outro cliente!');
        }
        return $this->redirect(['index']);
    }

    /**
     * Creates a new Fatura model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    { /*
        $dataAtual = new \DateTime();
        $valorArtigosSiva = LinhaFatura::find()->sum('valor');
        $valorIva = LinhaFatura::find()->sum('valor_iva');
        $valorFatura = $valorArtigosSiva + $valorIva;

        $fatura = new Fatura();
        $fatura->data = $dataAtual->format('Y-m-d H:i:s');
        $fatura->valor_fatura = $valorFatura;
        $fatura->perfil_id = Yii::$app->user->id;
        $fatura->estado = 'Emitida';
        $fatura->save();


        return $this->redirect(['index']);
 */
    }

    /**
     * Updates an existing Fatura model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    /* public function actionUpdate($id)
     {
         $model = $this->findModel($id);
         if (Yii::$app->user->can('updateProprioCliente', ['perfil' => Yii::$app->user->id])) {
             if($model->perfil_id == Yii::$app->user->id){
                 if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
                     return $this->redirect(['view', 'id' => $model->id]);
                 }
             }else{
                 Yii::$app->session->setFlash('error', 'Não pode fazer update da fatura de outro cliente!');
                 return $this->redirect(['index']);
             }
         }else{
             Yii::$app->session->setFlash('error', 'Não tem permissões!');
             return $this->redirect(['index']);
         }
         return $this->redirect('index' );
     }*/

    public function actionPagar($id)
    {
        $model = $this->findModel($id);
        if (Yii::$app->user->can('updateProprioCliente', ['perfil' => Yii::$app->user->id])) {
            if ($model->perfil_id == Yii::$app->user->id) {
                $model->estado = "Paga";
                $model->data = (new \DateTime())->format('Y-m-d H:i:s');
                $model->save();
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('error', 'Não tem permissões para pagar faturas de outro cliente!');
            }
        } else {
            Yii::$app->session->setFlash('error', 'Não tem permissões para pagar faturas de outro cliente!');
        }
        return $this->redirect(['index']);
    }

    /**
     * Deletes an existing Fatura model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (Yii::$app->user->can('deleteProprioCliente', ['perfil' => Yii::$app->user->id])) {
            $model = $this->findModel($id);
            if ($model->perfil_id == Yii::$app->user->id) {
                if ($model->canDeleteFatura()) {//se for emitida apaga

                    $mqtt = new phpMQTT('localhost', 1883, 'ClientId'); // Certifique-se de ajustar os detalhes da conexão MQTT
                    if ($mqtt->connect()) {
                        $mqtt->publish('FATURADELETE', 'Fatura excluída: ' . $id, 1);
                        $mqtt->close();
                    } else {
                        Yii::error('Falha ao conectar ao servidor MQTT.');
                    }
                    $model->delete();
                    Yii::$app->session->setFlash('success', 'Fatura removida com sucesso!');
                } else {
                    Yii::$app->session->setFlash('error', 'Não pode remover uma fatura PAGA!');
                }
            }else{
                Yii::$app->session->setFlash('error', 'Não tem permissões!');
            }
        } else {
            Yii::$app->session->setFlash('error', 'Não tem permissões!');
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Fatura model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Fatura the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Fatura::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionImprimir($id)
    {
        $this->layout = 'blank';

        if (Yii::$app->user->can('updateProprioCliente', ['perfil' => Yii::$app->user->id])) {
            $model = $this->findModel($id);
            if ($model->perfil_id == Yii::$app->user->id) {
                return $this->render('imprimir', [
                    'model' => $model,
                    'empresa' => Empresa::find()->one(),
                    'linhasFaturas' => LinhaFatura::find()->where(['fatura_id' => $id])->all(),

                ]);
            } else {
                Yii::$app->session->setFlash('error', 'Não tem permissões para visualizar uma fatura de outro cliente!');
            }
        } else {
            Yii::$app->session->setFlash('error', 'Não tem permissões para visualizar uma fatura de outro cliente!');
        }
        return $this->redirect(['index']);
    }
}
