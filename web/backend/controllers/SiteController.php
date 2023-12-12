<?php

namespace backend\controllers;

use backend\models\AuthAssignment;
use backend\models\SignupForm;
use common\models\Artigo;
use common\models\Categoria;
use common\models\Empresa;
use common\models\Fornecedor;
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
                        'actions' => ['login', 'error'],//visitante só pode login e pagina de erro
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout', 'error'], // so tem acesso quem esta logado
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['permissionBackoffice'], //admin e funcionario
                    ],
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['editRoles'], //só o admin
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
        $empresa = new Empresa();
        $empresas = $empresa->find()->all();
        if (count($empresas) == 1) {
            return $this->render('index', [
                'numeroCategorias' => Categoria::getNumeroCategorias(),
                'numeroArtigos' => Artigo::getNumeroArtigos(),
                'numeroFornecedores' => Fornecedor::getNumeroFornecedores(),
                'numeroFuncionarios' => AuthAssignment::getNumeroFuncionarios(),
                'numeroClientes' => AuthAssignment::getNumeroClientes(),
                'empresa' => Empresa::find()->one(),
            ]);
        }

        return $this->redirect(['empresa/create']);// leva os parenteses retos quando é para outro controller
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
            if(!Yii::$app->user->can('permissionBackoffice')){
                return $this->actionLogout();
            }
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
    public function actionSignup()
    {

        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }
}
