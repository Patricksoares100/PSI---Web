<?php

namespace backend\controllers;


use backend\models\AlterarPasswordForm;
use backend\models\AuthAssignment;
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
                            'actions' => ['alterar-password'],
                            'allow' => true,
                            'roles' => ['updatePassword'], //admin e funcionario
                        ],
                        [
                            'actions' => ['delete', 'create', 'atualizarstatus', 'atualizarrole'],
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
        $user = User::findOne($model->id);

        if (Yii::$app->user->can('permissionBackoffice', ['perfil' => $id])) {
            return $this->render('view', [
                'model' => $model,
                'user' => $user,
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
        $role = $model->getRole();// role de quem vai ser alterado
        $user = User::findOne($model->id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {

            if ($role == 'Cliente') {
                $user->status = Yii::$app->request->post('Perfil')['status']; // funcionario pode alterar
                if (Yii::$app->user->can('editRoles')) {
                    $user->username = Yii::$app->request->post('Perfil')['username'];// admin altera o resto
                    $user->email = Yii::$app->request->post('Perfil')['email'];
                }
            } else if ($role == 'Funcionario') {
                if (Yii::$app->user->can('updateDadosPessoais', ['perfil' => $id])) {
                    $user->username = Yii::$app->request->post('Perfil')['username'];
                    $user->email = Yii::$app->request->post('Perfil')['email'];
                }
                if (Yii::$app->user->can('editRoles')) {
                    $user->username = Yii::$app->request->post('Perfil')['username'];
                    $user->email = Yii::$app->request->post('Perfil')['email'];
                    $user->status = Yii::$app->request->post('Perfil')['status'];// so admin altera o status do funcionario
                }
                if (Yii::$app->user->can('updatePassword')) {
                    $user->password = Yii::$app->request->post('Perfil')['password'];
                }
            } else {
                $user->username = Yii::$app->request->post('Perfil')['username'];// admin altera tudo
                $user->email = Yii::$app->request->post('Perfil')['email'];
                $user->status = Yii::$app->request->post('Perfil')['status'];
            }
            /*if (!empty($model->novaPassword) && ($model->novaPassword == $model->confirmarPassword)) {
                $user->updatePassword($model->novaPassword);
            }*/
            $user->save();

            return $this->redirect(['view', 'id' => $model->id]);
        }

        if ($role == 'Cliente') {
            return $this->render('update', ['model' => $model]);

        } else if ($role == 'Funcionario') {
            if (Yii::$app->user->can('updateDadosPessoais', ['perfil' => $id]) || Yii::$app->user->can('editRoles')) {
                return $this->render('update', ['model' => $model]);
            }
        } else {
            if (Yii::$app->user->can('updateDadosPessoais', ['perfil' => $id])) {
                return $this->render('update', ['model' => $model]);
            }
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionAtualizarrole($id)
    {
        try {
            if ($id == 1) {// se for administrador
                throw new \Exception("Não pode alterar o role do administrador");
            }
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->redirect(['site/index']);
        }
        $model = $this->findModel($id);
        if ($model->setNewRole($id) == 1) {// troca o role de funcionario para cliente e vice versa
            return $this->redirect(['index']);
        }
    }

    public function actionAtualizarstatus($id)
    {
        try {
            if ($id == 1) {// se for administrador
                throw new \Exception("Não pode alterar o estado do administrador");
            }
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->redirect(['site/index']);
        }
        $model = $this->findModel($id);
        if ($model->setNewStatus($id) == 1) {// troca o status entre o 9 e o 10
            return $this->redirect(['index']);
        }
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
        if ($perfil != null && $perfil->id != 1) {// e que não é o admin
            $userId = $perfil->id;
            // apagar o perfil
            $perfil->delete();

            // Excluir o user associado ao perfil
            if ($userId != null) {
                $user = User::findOne(['id' => $userId]); // primeiro id é da tabela user o userID é o id que guardamos acima
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

    public function actionAlterarPassword($id)
    {
        $model = new AlterarPasswordForm();
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $valid = $model->validate();
                if ($valid) {

                    $user = User::findOne(['id' => $id]);

                    $user->setPassword($model->novaPassword);

                    if ($user->save())
                        return $this->redirect(['view', 'id' => $user->id, 'msg' => 'Password alterada com sucesso!']);
                    else
                        return $this->redirect(array('alterar-password', 'msg' => 'Erro ao alterar password!'));
                }
            }
        }

        return $this->render('alterar-password', ['model' => $model]);
    }
}
