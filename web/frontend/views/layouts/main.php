<?php

/** @var \yii\web\View $this */

/** @var string $content */

use app\models\ArtigoSearch;
use common\models\Avaliacao;
use common\models\Categoria;
use common\models\Empresa;
use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\helpers\Url;
use yii\widgets\ActiveForm;


AppAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>" class="h-100">

    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Favicon -->
        <link href="img/favicon.ico" rel="icon">

        <!-- Google Web Fonts -->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

        <!-- Font Awesome -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

        <!-- Libraries Stylesheet -->
        <link href="lib/animate/animate.min.css" rel="stylesheet">
        <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

        <!-- Customized Bootstrap Stylesheet -->
        <link href="css/style.css" rel="stylesheet">


        <!-- JavaScript Libraries -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
        <script src="lib/easing/easing.min.js"></script>
        <script src="lib/owlcarousel/owl.carousel.min.js"></script>

        <!-- Contact Javascript File -->
        <script src="mail/jqBootstrapValidation.min.js"></script>
        <script src="mail/contact.js"></script>

        <!-- Template Javascript -->
        <script src="js/main.js"></script>

        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>

    <body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>

    <header>
        <!-- Topbar Start -->
        <div class="container-fluid">
            <div class="row bg-secondary py-1 px-xl-5">
                <div class="col-lg-6 d-none d-lg-block">
                    <div class="d-inline-flex align-items-center h-100">
                        <a class="text-body mr-3" href="<?= \yii\helpers\Url::to(['/site/about']) ?>">About</a>
                        <a class="text-body mr-3" href="<?= \yii\helpers\Url::to(['/site/contact']) ?>">Entre em Contacto</a>
                    </div>
                </div>
                <div class="col-lg-6 text-center text-lg-right">
                    <div class="d-inline-flex align-items-center">
                        <div class="btn-group">
                            <?php
                            if (Yii::$app->user->isGuest) {
                                echo '<a class="btn btn-primary" href="' . \yii\helpers\Url::to(['/site/signup']) . '">Registo</a>';
                            }
                            ?>
                            <?php
                            $idUser = Yii::$app->user->id;
                            // Verifica se o usuário está logado
                            if (Yii::$app->user->isGuest) {
                                // Mostra o botão de login
                                echo Html::a('Login', Url::to(['site/login']), ['class' => 'btn btn-primary']);
                            } else {
                                echo '<div class="btn-group">
                                <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown" aria-expanded="false">' . Yii::$app->user->identity->username . '</button>
                                <div class="dropdown-menu dropdown-menu-right" style="position: absolute; transform: translate3d(-56px, 31px, 0px); top: 0px; left: 0px; will-change: transform;" x-placement="bottom-end">
                                    ' . Html::a('Ver Perfil', ['/perfil/view', 'id' => $idUser], ['class' => 'dropdown-item', 'data-method' => 'post']) . '
                                    ' . Html::a('Alterar Dados', ['/perfil/update', 'id' => $idUser], ['class' => 'dropdown-item', 'data-method' => 'post']) . '
                                     ' . Html::a('Minhas Avaliações', ['/avaliacao/index'], ['class' => 'dropdown-item', 'data-method' => 'post']) . ' 
                                    ' . Html::a('Logout', ['/site/logout'], ['class' => 'dropdown-item', 'data-method' => 'post']) . '
                                </div>
                            </div>';
                            }
                            ?>
                        </div>
                    </div>
                    </form>
                </div>
                <div class="row align-items-center bg-light py-3 px-xl-5 d-none d-lg-flex">
                    <div class="col-lg-4">
                        <a href="<?= Url::to(['/site/index']) ?>" class="text-decoration-none">
                            <?php if (Empresa::find()->one() != null) {
                                $empresa = Empresa::find()->one() ?>
                                <span class="h1 text-uppercase text-dark bg-primary px-2 ml-n1"><?= $empresa->nome ?></span>
                            <?php } else { ?>
                                <span class="h1 text-uppercase text-dark bg-primary px-2 ml-n1">Insira uma empresa</span>
                            <?php } ?>
                        </a>
                    </div>
                    <?php

                    $searchModel = new ArtigoSearch();

                    ?>

                    <div class="col-lg-4 col-6 text-left">
                        <?php $form = ActiveForm::begin([
                            'action' => ['artigo/index'],
                            'method' => 'get',
                            'options' => ['class' => 'form-inline'],
                        ]); ?>
                        <div class="form-group">
                            <div class="input-group">
                                <?= $form->field($searchModel, 'nome')->textInput(['maxlength' => true])->label(false)  ?>
                            </div>
                            <span class="text-primary" style="margin-left: 10px;">
                                    <?= Html::submitButton('Pesquisar', ['class' => 'btn btn-primary']) ?>
                                </span>
                        </div>
                        <?php ActiveForm::end(); ?>

                    </div>
                    <div class="col-lg-4 col-6 text-right">

                        <?php
                        // Recuperar a empresa da  bd 
                        $empresa = Empresa::find()->one();

                        // Verificar que a empresa foi encontrada antes de exibir o telefone
                        if ($empresa) {
                            echo '<p class="m-0">' . $empresa->nome . '</p>';
                            echo '<h5 class="m-0">' . $empresa->telefone . '</h5>';
                        } else {
                            echo '<p class="m-0">Nome da empresa não disponível</p>';
                            echo '<p class="m-0">Número de telefone não disponível</p>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- Topbar End -->
        <!-- Navbar Start -->
        <div class="container-fluid bg-dark mb-30">
            <div class="row px-xl-5">
                <div class="col-lg-3 d-none d-lg-block">
                    <a class="btn d-flex align-items-center justify-content-between bg-primary w-100"
                       data-toggle="collapse" href="#navbar-vertical" style="height: 65px; padding: 0 30px;">
                        <h6 class="text-dark m-0"><i class="fa fa-bars mr-2"></i>Categorias</h6>
                        <i class="fa fa-angle-down text-dark"></i>
                    </a>
                    <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 bg-light"
                         id="navbar-vertical" style="width: calc(100% - 30px); z-index: 999;">
                        <div class="navbar-nav w-100">
                            <?php
                            $categorias = Categoria::find()->all(); // vai buscar todas as categorias
                            foreach ($categorias as $categoria) { // mostra todas as categorias
                                echo Html::a($categoria->nome, ['artigo/categorias', 'id' => $categoria->id], ['class' => 'nav-item nav-link']);
                            }
                            ?>
                        </div>
                    </nav>

                </div>
                <div class="col-lg-9">
                    <nav class="navbar navbar-expand-lg bg-dark navbar-dark py-3 py-lg-0 px-0">
                        <a href="<?= Url::to(['/site/index']) ?>" class="text-decoration-none d-block d-lg-none">
                            <span class="h1 text-uppercase text-dark bg-primary px-2 ml-n1"><?= $empresa->nome ?></span>
                        </a>
                        <button type="button" class="navbar-toggler" data-toggle="collapse"
                                data-target="#navbarCollapse">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                            <div class="navbar-nav mr-auto py-0">
                                <a href="<?= Url::to(['/site/index']) ?>" class="nav-item nav-link active">Home</a>
                            </div>
                            <div class="navbar-nav mr-auto py-0">
                                <a href="<?= Url::to(['/artigo/index']) ?>"
                                   class="nav-item nav-link active">Artigos</a>
                            </div>
                            <div class="navbar-nav mr-auto py-0">
                                <?php if (!Yii::$app->user->isGuest) : ?>
                                    <a href="<?= Url::to(['/fatura/index']) ?>"
                                       class="nav-item nav-link active">Faturas</a>
                                <?php endif; ?>
                            </div>
                            <div class="navbar-nav ml-auto py-0 d-none d-lg-block">
                                <a href="<?= Url::to(['/favorito/index']) //favorito/algo
                                ?>" class="btn px-0">
                                    <i class="fas fa-heart text-primary"></i>
                                    <span class="badge text-secondary border border-secondary rounded-circle"
                                          style="padding-bottom: 2px;"><?php $numberFav = \common\models\Favorito::find()->count(); ?>
                                        <?= $numberFav ?>
                                    </span>
                                </a>
                                <a href="<?= Url::to(['/linhacarrinho/index']) //carrinho/algo
                                ?>" class="btn px-0 ml-3">
                                    <i class="fas fa-shopping-cart text-primary"></i>
                                    <span class="badge text-secondary border border-secondary rounded-circle"
                                          style="padding-bottom: 2px;"><?php $numberCar = \common\models\LinhaCarrinho::find()->count(); ?>
                                        <?= $numberCar ?>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <main role="main" class="flex-shrink-0">
        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </main>

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-secondary mt-5 pt-5">
        <div class="row px-xl-5 pt-5">
            <div class="col-lg-4 col-md-12 mb-5 pr-3 pr-xl-5">
                <h5 class="text-secondary text-uppercase mb-4">Entre em contato conosco</h5>
                <?php if ($empresa) { ?>
                    <p class="mb-4"><?= $empresa->nome ?>, é uma empresa especializada em artigos para oferta, com
                        produção própria e uma vasta experiência no sector de brindes publicitários.</p>
                    <p class="mb-2"><i
                                class="fa fa-map-marker-alt text-primary mr-3"></i><?= $empresa->morada . ' ' . $empresa->codigo_postal . ' ' . $empresa->localidade ?>
                    </p>
                    <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i><?= $empresa->email ?></p>
                    <p class="mb-0"><i class="fa fa-phone-alt text-primary mr-3"></i><?= $empresa->telefone ?></p>
                <?php } else {
                    echo '<p class="mb-4"> Insira uma empresa,  é uma empresa especializada em artigos para oferta, com produção própria e uma vasta experiência no sector de brindes publicitários.</p>';
                } ?>
            </div>
            <div class="col-lg-8 col-md-12">
                <div class="row">

                    <div class="col-md-4 mb-5">

                    </div>
                    <div class="col-md-4 mb-5">
                        <form action="">

                        </form>
                        <h6 class="text-secondary text-uppercase mt-4 mb-3">JUNTE-SE A NÓS</h6>
                        <div class="d-flex">
                            <a class="btn btn-primary btn-square mr-2" href="#"><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-primary btn-square mr-2" href="#"><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-primary btn-square mr-2" href="#"><i class="fab fa-linkedin-in"></i></a>
                            <a class="btn btn-primary btn-square" href="#"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row border-top mx-xl-5 py-4" style="border-color: rgba(256, 256, 256, .1) !important;">
            <div class="col-md-6 px-xl-0">
                <p class="mb-md-0 text-center text-md-left text-secondary">
                    &copy; <a class="text-primary" href="#">Domain</a>. All Rights Reserved. Designed
                    by
                    <a class="text-primary" href="https://htmlcodex.com">HTML Codex</a>
                </p>
            </div>
            <div class="col-md-6 px-xl-0 text-center text-md-right">
                <img class="img-fluid" src="img/payments.png" alt="">
            </div>
        </div>
    </div>
    <!-- Footer End -->


    <?php $this->endBody() ?>
    </body>

    </html>
<?php $this->endPage();
