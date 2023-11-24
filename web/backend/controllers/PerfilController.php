<?php

namespace backend\controllers;

use common\models\Perfil;
use common\models\User;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii;

/**
 * PerfilController implements the CRUD actions for Perfil model.
 */
class PerfilController extends Controller
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
                            'actions' => ['update', 'view', 'index'],
                            'allow' => true,
                            'roles' => ['permissionBackoffice'], //admin e funcionario
                        ],
                        [
                            'actions' => ['delete', 'create'],
                            'allow' => true,
                            'roles' => ['editRoles'], //só admin
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
     * Lists all Perfil models.
     *
     * @return string
     */
    public function actionIndex()
    {

        $auth = \Yii::$app->authManager;
        $dataProvider = new ActiveDataProvider([
            'query' => Perfil::find(),
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
            'auth' => $auth,
        ]);
    }

    /**
     * Displays a single Perfil model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */

    public function actionView($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->user->can('permissionBackoffice', ['perfil' => $id])) {
            return $this->render('view', [
                'model' => $model,
            ]);
            // O usuário tem permissão para acessar/modificar os dados pessoais deste perfil
        }
        // O usuário não tem permissão

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Creates a new Perfil model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Perfil();
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
     * Updates an existing Perfil model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $role = $model->getRole();
        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        if($role == 'Cliente'){
            if (Yii::$app->user->can('permissionBackoffice', ['perfil' => $id])) {//updateDadosPessoais
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }else if($role == 'Funcionario'){
            if (Yii::$app->user->can('updateDadosPessoais', ['perfil' => $id]) || Yii::$app->user->can('editRoles')) {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }else {
            if (Yii::$app->user->can('updateDadosPessoais', ['perfil' => $id])) {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }




        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Deletes an existing Perfil model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
public function actionDelete($id)
{
    $perfil = $this->findModel($id);
    // Certificar de que o perfil foi encontrado antes de tentar excluir
    if ($perfil != null) {
        $userId = $perfil->id; 
        // apagar o perfil
        $perfil->delete();

        // Excluir o user associado ao perfil
        if ($userId != null) {
            $user = User::findOne(['id' => $userId]);// primeiro id é da tabela user o userID é o id que guardamos acima
            if ($user !== null) {
                $user->delete();
            } 
        }
    }
    return $this->redirect(['index']);
}


    /**
     * Finds the Perfil model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Perfil the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Perfil::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
