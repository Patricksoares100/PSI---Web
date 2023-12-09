<?php

/** @var yii\web\View $this */

use common\models\Artigo;
use common\models\Categoria;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'My Yii Application';
?>
<!-- Carousel Start -->
<div class="container-fluid mb-3">
    <div class="row px-xl-5">
        <div class="col-lg-8">
            <div id="header-carousel" class="carousel slide carousel-fade mb-30 mb-lg-0" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#header-carousel" data-slide-to="0" class="active"></li>
                    <li data-target="#header-carousel" data-slide-to="1"></li>
                    <li data-target="#header-carousel" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">

                    <?php
                    $categoria1 = Categoria::find()->orderBy('RAND()')->one(); //tem de levar condição if para nao rebentar qndo a base de dados nao tiver categorias
                    if ($categoria1): ?>
                        <div class="carousel-item position-relative active" style="height: 430px;">
                            <img class="position-absolute w-100 h-100" src="img/pen_wallpaper_index.jpg"
                                 style="object-fit: cover;">
                            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                <div class="p-3" style="max-width: 700px;">
                                    <h1 class="display-4 text-white mb-3 animate__animated animate__fadeInDown"><?= $categoria1->nome ?> </h1>
                                    <p class="mx-md-5 px-5 animate__animated animate__bounceIn">Explore o mundo da
                                        escrita com a nossa exclusiva coleção de canetas personalizadas</p>
                                    <a class="btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp"
                                       href="<?= Url::to(['artigo/categorias', 'id' => $categoria1->id]) ?>">Compra
                                        Agora</a>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="carousel-item position-relative active" style="height: 430px;">
                            <img class="position-absolute w-100 h-100" src="img/pen_wallpaper_index.jpg"
                                 style="object-fit: cover;">
                            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                <div class="p-3" style="max-width: 700px;">
                                    <h6 class="text-white text-uppercase">A definir categoria</h6>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php $categoria2 = Categoria::find()->orderBy('RAND()')->one();
                    if ($categoria2): ?>
                    <div class="carousel-item position-relative" style="height: 430px;">
                        <img class="position-absolute w-100 h-100" src="img/agenda.jpg" style="object-fit: cover;">
                        <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                            <div class="p-3" style="max-width: 700px;">
                                <h1 class="display-4 text-white mb-3 animate__animated animate__fadeInDown"><?= $categoria2->nome ?> </h1>
                                <p class="mx-md-5 px-5 animate__animated animate__bounceIn">A indicar mensgaem que
                                    queremos</p>
                                <a class="btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp"
                                   href="<?= Url::to(['artigo/categorias', 'id' => $categoria2->id]) ?>">Compra
                                    Agora</a>
                            </div>
                        </div>
                        <?php else: ?>
                        <div class="carousel-item position-relative" style="height: 430px;">
                            <img class="position-absolute w-100 h-100" src="img/agenda.jpg" style="object-fit: cover;">
                            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                <div class="p-3" style="max-width: 700px;">
                                    <h1 class="display-4 text-white mb-3 animate__animated animate__fadeInDown"></h1>
                                    <h6 class="text-white text-uppercase">A definir categoria</h6>
                                </div>
                            </div>
                            <h6 class="text-white text-uppercase">A definir categoria</h6>
                            <?php endif; ?>
                        </div>
                        <?php $categoria3 = Categoria::find()->orderBy('RAND()')->one();
                        if ($categoria3): ?>
                            <div class="carousel-item position-relative" style="height: 430px;">
                                <img class="position-absolute w-100 h-100" src="img/acessorios_homem.jpg"
                                     style="object-fit: cover;">
                                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                    <div class="p-3" style="max-width: 700px;">
                                        <h1 class="display-4 text-white mb-3 animate__animated animate__fadeInDown"><?= $categoria3->nome ?> </h1>
                                        <p class="mx-md-5 px-5 animate__animated animate__bounceIn">Elevamos o estilo
                                            masculino com a nossa seleção de acessórios cuidadosamente escolhidos</p>
                                        <a class="btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp"
                                           href="<?= Url::to(['artigo/categorias', 'id' => $categoria3->id]) ?>">Compra
                                            Agora</a>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="product-offer mb-30" style="height: 200px;">
                    <img class="img-fluid" src="img/mochila.jpg" alt="">
                    <div class="offer-text">
                        <div class="offer-text">
                            <?php
                            $categoria = Categoria::find()->orderBy('RAND()')->one(); //tem de levar condição if para nao rebentar qndo a base de dados nao tiver categorias
                            if ($categoria): ?>
                                <h6 class="text-white text-uppercase"><?= $categoria->nome ?></h6>
                                <h3 class="text-white mb-3">Ofertas Especiais</h3>
                                <a href="<?= Url::to(['artigo/categorias', 'id' => $categoria->id]) ?>"
                                   class="btn btn-primary">Compra Agora</a>
                            <?php else: ?>
                                <h6 class="text-white text-uppercase">A definir categoria</h6>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="product-offer mb-30" style="height: 200px;">
                    <img class="img-fluid" src="img/canecaIndex.jpg" alt="">
                    <div class="offer-text">
                        <?php
                        $categoria = Categoria::find()->orderBy('RAND()')->one();
                        if ($categoria): ?>
                            <h6 class="text-white text-uppercase"><?= $categoria->nome ?></h6>
                            <h3 class="text-white mb-3">Ofertas Especiais</h3>
                            <a href="<?= Url::to(['artigo/categorias', 'id' => $categoria->id]) ?>"
                               class="btn btn-primary">Compra Agora</a>
                        <?php else: ?>
                            <h6 class="text-white text-uppercase">A definir categoria</h6>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Carousel End -->


    <!-- Featured Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5 pb-3">
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <h1 class="fa fa-check text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">Quality Product</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <h1 class="fa fa-shipping-fast text-primary m-0 mr-2"></h1>
                    <h5 class="font-weight-semi-bold m-0">Free Shipping</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <h1 class="fas fa-exchange-alt text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">14-Day Return</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <h1 class="fa fa-phone-volume text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">24/7 Support</h5>
                </div>
            </div>
        </div>
    </div>
    <!-- Featured End -->


    <!-- Categories Start -->
    <div class="container-fluid pt-5">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Categorias</span>
        </h2>
        <div class="row px-xl-5 pb-3">
            <?php
            $categorias = Categoria::find()->all(); // vai buscar todas as categorias
            foreach ($categorias as $categoria) { // mostra todas as categorias
                ?>
                <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                    <a class="text-decoration-none" href="">
                        <div class="cat-item d-flex align-items-center mb-4">
                            <div class="overflow-hidden" style="width: 100px; height: 100px;">
                                <img class="img-fluid" src="img/cat-1.jpg" alt="">
                            </div>
                            <div class="flex-fill pl-3">
                                <h6><?= Html::a($categoria->nome, ['artigo/categorias', 'id' => $categoria->id]) ?></h6>
                            </div>
                        </div>
                    </a>
                </div>
            <?php } ?>
        </div>

    </div>
    <!-- Categories End -->


    <!-- Products Start -->
    <div class="container-fluid pt-5 pb-3">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Featured Products</span>
        </h2>
        <div class="row px-xl-5">
            <?php

            $artigos = Artigo::find()->all(); // vai buscar todas as categorias
            if ($artigos != null) {
                $artigos = array_slice($artigos, 0, 12); // Limita a apresentação a 20 artigos para nao ficar estupidamente grande
                $indicesAleatorios = array_rand($artigos, count($artigos));  // Obtém índices aleatórios
            }
            foreach ($artigos as $artigo) { // mostra todas as categorias
                ?>
                <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                    <div class="product-item bg-light mb-4">
                        <div class="product-img position-relative overflow-hidden">
                            <img class="img-fluid w-100" src="img/product-1.jpg" alt="">
                            <div class="product-action">
                                <a class="btn btn-outline-dark btn-square" href=""><i
                                            class="fa fa-shopping-cart"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i class="far fa-heart"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-sync-alt"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-search"></i></a>
                            </div>
                        </div>
                        <div class="text-center py-4">
                            <a class="h6 text-decoration-none text-truncate"
                               href="<?= Yii::$app->urlManager->createUrl(['artigo/detail', 'id' => $artigo->id]) ?>">
                                <!-- vai criar o link, indicando o destino e mandando o id por parametro-->
                                <?= $artigo->nome ?>
                            </a>

                            <div class="d-flex align-items-center justify-content-center mt-2">
                                <h5><?= number_format($artigo->preco, 2) ?>€</h5>
                            </div>
                            <div class="d-flex align-items-center justify-content-center mb-1">
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small>(99)</small>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <!-- Products End -->


    <!-- Offer Start -->
    <div class="container-fluid pt-5 pb-3">
        <div class="row px-xl-5">
            <div class="col-md-6">
                <?php
                $categoriaFooter = Categoria::find()->orderBy('RAND()')->one();
                if ($categoriaFooter): ?>
                    <div class="product-offer mb-30" style="height: 300px;">
                        <img class="img-fluid" src="img/mochila.jpg" alt="">
                        <div class="offer-text">
                            <h3 class="text-white mb-3"><?= $categoriaFooter->nome ?></h3>
                            <a href="<?= Url::to(['artigo/categorias', 'id' => $categoriaFooter->id]) ?>"
                               class="btn btn-primary">Shop Now</a>
                        </div>
                    </div>
                <?php else: ?>
                    <h3 class="text-white mb-3">A definir categoria</h3>
                <?php endif; ?>
            </div>
            <div class="col-md-6">
                <?php
                $categoriaFooter2 = Categoria::find()->orderBy('RAND()')->one();
                if ($categoriaFooter2): ?>
                <div class="product-offer mb-30" style="height: 300px;">
                    <img class="img-fluid" src="img/canecaIndex.jpg" alt="">
                    <div class="offer-text">
                        <h3 class="text-white mb-3"><?= $categoriaFooter2->nome ?></h3>
                        <a href="<?= Url::to(['artigo/categorias', 'id' => $categoriaFooter2->id]) ?>"
                           class="btn btn-primary">Shop Now</a>
                    </div>
                    <?php else: ?>
                        <h3 class="text-white mb-3">A definir categoria</h3>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Offer End -->


    <!-- Products Start -->

    <!-- Products End -->


    <!-- Vendor Start -->
    <div class="container-fluid py-5">
        <div class="row px-xl-5">
            <div class="col">
                <div class="owl-carousel vendor-carousel">
                    <div class="bg-light p-4">
                        <img src="img/vendor-1.jpg" alt="">
                    </div>
                    <div class="bg-light p-4">
                        <img src="img/vendor-2.jpg" alt="">
                    </div>
                    <div class="bg-light p-4">
                        <img src="img/vendor-3.jpg" alt="">
                    </div>
                    <div class="bg-light p-4">
                        <img src="img/vendor-4.jpg" alt="">
                    </div>
                    <div class="bg-light p-4">
                        <img src="img/vendor-5.jpg" alt="">
                    </div>
                    <div class="bg-light p-4">
                        <img src="img/vendor-6.jpg" alt="">
                    </div>
                    <div class="bg-light p-4">
                        <img src="img/vendor-7.jpg" alt="">
                    </div>
                    <div class="bg-light p-4">
                        <img src="img/vendor-8.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Vendor End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>