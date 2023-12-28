<?php

namespace backend\controllers;

use common\models\Artigo;
use common\models\Categoria;
use common\models\Fornecedor;
use common\models\Iva;
use yii\base\View;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
use yii\web\UploadedFile;


/**
 * ArtigoController implements the CRUD actions for Artigo model.
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
                'access' => [
                    'class' => AccessControl::class,
                    // como n esta o only aqui , quer dizer q tudo é proibido
                    'rules' => [
                        [
                            'actions' => ['error'], // so tem acesso quem esta logado
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                        [
                            'actions' => ['index', 'view', 'update', 'delete', 'create', 'atualizarstock'],
                            'allow' => true,
                            'roles' => ['permissionBackoffice'],
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
     * Lists all Artigo models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Artigo::find(),
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
     * Displays a single Artigo model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $imagens = $model->imagens;
        return $this->render('view', [
            'model' => $model,
            'imagens' => $imagens,
        ]);
    }

    /**
     * Creates a new Artigo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Artigo();
        //https://stackoverflow.com/questions/29449019/yii2-validate-only-create-action
        //$model->scenario = 'create';

        $fornecedores = Fornecedor::find()->all();
        $ivas = Iva::find()->all();
        $categorias = Categoria::find()->all();
        try {
            if (empty($fornecedores)) {
                throw new \Exception("Não pode criar um artigo sem um fornecedor criado previamente");
            }
            if (empty($ivas)) {
                throw new \Exception("Não pode criar um artigo sem uma taxa de IVA criada previamente");
            }
            if (empty($categorias)) {
                throw new \Exception("Não pode criar um artigo sem uma Categoria criada previamente");
            }
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
            //return $this->goHome();
            return  $this->goBack();
        }

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {

                $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
                if ($model->upload() ) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'fornecedores' =>$fornecedores,
            'ivas'=>$ivas,
            'categorias'=>$categorias,

        ]);
    }

    /**
     * Updates an existing Artigo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
            if ($model->upload() ) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        $fornecedores = Fornecedor::find()->all();
        $ivas = Iva::find()->all();
        $categorias = Categoria::find()->all();
        return $this->render('update', [
            'model' => $model,
            'fornecedores' =>$fornecedores,
            'ivas'=>$ivas,
            'categorias'=>$categorias,
        ]);
    }

    /**
     * Deletes an existing Artigo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $podeApagar = Artigo::canDeleteArtigo($id);
        if($podeApagar == false){// false= nao pode apagar
            \Yii::$app->session->setFlash('error',"Não pode remover o Artigo devido já estar relacionado com uma ou mais fatura(s)!");
        }else{
            $this->findModel($id)->delete();
        }


        return $this->redirect(['index']);
    }

    /**
     * Finds the Artigo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Artigo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Artigo::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionAtualizarstock($id, $sinal){// em vez de apagar ele manda mensagem ...temos q passar isso para o modelo
        $model = $this->findModel($id);
        if($sinal == '+'){
            $model->stock_atual++;
        }
        else{
            if($model->stock_atual > 0) {
            $model->stock_atual--;
        }else{
                Yii::$app->session->setFlash('error', 'Não pode reduzir mais a quantidade');
                //return $this->goHome();
                return $this->redirect(['index']);
            }
        }
        if ($model->save()) {
            return $this->redirect(['index', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }
}
