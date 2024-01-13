<?php

namespace backend\controllers;

use Bluerhinos\phpMQTT;
use common\models\Artigo;
use common\models\Categoria;
use common\models\Fornecedor;
use common\models\Iva;
//use MqttServices;
use yii\base\View;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
use yii\web\UploadedFile;
use \common\Services\MqttServices;


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
        $model->scenario = 'create';

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
                    // Chame o método FazPublishNoMosquitto após salvar o modelo e nao antes como estava
                    $this->publishArtigoMessage("INSERT", "Artigo criado", $model->id);
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        //MqttServices::FazPublishNoMosquitto("INSERT", "criado");

        return $this->render('create', [
            'model' => $model,
            'fornecedores' =>$fornecedores,
            'ivas'=>$ivas,
            'categorias'=>$categorias,

        ]);


    }

    protected function publishArtigoMessage($canal, $mensagem, $artigoId)
    {
        $model = Artigo::findOne($artigoId);

        if ($model !== null) {
            $artigoData = [
                'id' => $model->id,
                'nome' => $model->nome,
                'descricao' => $model->descricao,
                'referencia' => $model->referencia,
                'preco' => $model->preco,
                'stock_atual' => $model->stock_atual,
                'iva_id' => $model->iva_id,
                'fornecedor_id' => $model->fornecedor_id,
                'categoria_id' => $model->categoria_id,
                'perfil_id' => $model->perfil_id,
            ];

            $message = [
                'canal' => $canal,
                'mensagem' => $mensagem,
                'artigoObjeto' => $artigoData,
            ];

            $this->FazPublishNoMosquitto($canal, json_encode($message));
        }
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
            //$sms=`o artigo {$artigo->nome} foi apagado`
            self::FazPublishNoMosquitto("INSERT", "apagou");
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
            if($model->stock_atual == 0){
                $this->publishArtigoMessage("ARRTIGOSTOCK", "Artigo voltou a estar em Stock", $model->id);
            }
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

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        //Obter dados do registo em causa
        $id = $this->id;
        $nome = $this->nome;
        $descricao = $this->descricao;
        $referencia = $this->referencia;
        $preco = $this->preco;
        $stock_atual = $this->stock_atual;
        $iva_id = $this->iva_id;
        $fornecedor_id = $this->fornecedor_id;
        $categoria_id = $this->categoria_id;
        $perfil_id = $this->perfil_id;

        $myObj = new \stdClass();
        $myObj->id = $id;
        $myObj->nome = $nome;
        $myObj->descricao = $descricao;
        $myObj->referencia = $referencia;
        $myObj->preco = $preco;
        $myObj->stock_atual = $stock_atual;
        $myObj->iva_id = $iva_id;
        $myObj->fornecedor_id = $fornecedor_id;
        $myObj->categoria_id = $categoria_id;
        $myObj->perfil_id = $perfil_id;
        $myJSON = json_encode($myObj);
        if ($insert)
            $this->FazPublishNoMosquitto("INSERT", $myJSON);
        else
            $this->FazPublishNoMosquitto("UPDATE", $myJSON);
    }

    public function afterDelete()
    {
        parent::afterDelete();
        $prod_id = $this->id;
        $myObj = new \stdClass();
        $myObj->id = $prod_id;
        $myJSON = json_encode($myObj);
        $this->FazPublishNoMosquitto("DELETE", $myJSON);
    }

    public static function FazPublishNoMosquitto($canal, $msg)
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

}
