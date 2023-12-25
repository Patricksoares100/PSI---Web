<?php

namespace frontend\controllers;

use frontend\models\AlterarPasswordForm;
use common\models\Perfil;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii;
use common\models\User;


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
            [   'access' => [
                'class' => AccessControl::class,
                'only' => ['update', 'view', 'alterar-password', 'confirmardados'], //tudo publico menos o q esta aqui, rotas afetadas pelo ACF
                'rules' => [
                    [
                        'actions' => [ 'view', 'alterar-password','update', 'confirmardados'],
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
     * Displays a single Perfil model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if(Yii::$app->user->can('updateDadosPessoais', ['perfil'=> $id])){

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
        }
    }
    public function actionConfirmardados()
    {
        $model = $this->findModel(Yii::$app->user->id);
        if (Yii::$app->user->can('updateProprioCliente', ['perfil' => Yii::$app->user->id])) {
            if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['linhafatura/create', 'iduser' => $model->id]);
            }
        }
        return $this->redirect('site/checkout');
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
        if (Yii::$app->user->can('updateProprioCliente', ['perfil' => Yii::$app->user->id])) {
            if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('update', [
            'model' => $model,
        ]);
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

    public function actionAlterarPassword()
    {
        $model = new AlterarPasswordForm();
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $valid = $model->validate();
                if ($valid) {

                    $user = User::findOne(['id' => Yii::$app->user->id]);

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
