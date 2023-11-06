<?php

namespace backend\controllers;

use common\models\LoginForm;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                // como n esta o only aqui , quer dizer q tudo é proibido
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'gerirProdutos'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'], // so tem acesso quem esta logado
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [

                        'actions' => ['gerirProdutos'],
                        'allow' => true,
                        'roles' => ['gerirProdutos'], //permission 
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
    public function actionEmpresa()
    {
        return $this->render('admin');
    }


    public function actionGerirProdutos()
    {
        //O QUE ESTA COMENTADO É PARA MOSTRAR ALGO ESPECIFICO QUANDO TIPOS DE USERS
        //DIFERENTES PODEM USAR A MESMA ACTION
        //if (Yii::$app->user->can('gerirProdutos')){
        return $this->render('gerirprodutos');
        // }
        // return $this->render('error_home');
    }
}
