<?php

/** @var yii\web\View $this */

use common\models\Artigo;
use common\models\Avaliacao;
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
                     //tem de levar condição if para nao rebentar qndo a base de dados nao tiver categorias
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

                    <?php
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
                        <?php
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
                            //tem de levar condição if para nao rebentar qndo a base de dados nao tiver categorias
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

    <!-- Categories End -->


    <!-- Products Start -->
    <div class="container-fluid pt-5 pb-3">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Featured Products</span>
        </h2>
        <div class="row px-xl-5">
            <?php
            if ($artigos != null) {
                $artigos = array_slice($artigos, 0, 12); // Limita a apresentação a 20 artigos para nao ficar estupidamente grande
                $indicesAleatorios = array_rand($artigos, count($artigos));  // Obtém índices aleatórios
            }
            foreach ($artigos as $artigo) { // mostra todas as categorias
                ?>
                <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                    <div class="product-item bg-light mb-4">

                        <div class="product-img position-relative overflow-hidden">
                            <img class="img-fluid w-100" src="<?=Yii::$app->params['caminhoBackend']. '/'. $artigo->imagens[0]->image_path?>" style="width: 5cm; height: 5cm;"  alt="Imagem do <?= $artigo->nome?>">

                            <div class="product-action">
                                <?php if ($artigo->stock_atual > 0): ?>
                                <a class="btn btn-outline-dark btn-square" href="<?= Url::to(['linhacarrinho/create', 'id' => $artigo->id])?>"><i
                                            class="fa fa-shopping-cart"></i></a>
                                <?php endif; ?>
                                <a class="btn btn-outline-dark btn-square" href="<?= Url::to(['favorito/create', 'id' => $artigo->id])?>"><i class="far fa-heart"></i></a>
                            </div>
                        </div>
                        <div class="text-center py-4">
                            <div class="d-flex align-items-center justify-content-center mb-1">
                                <?php
                                $avaliacoes = Avaliacao::find()->where(['artigo_id' => $artigo->id])->all();
                                $somaTotal = 0;
                                foreach ($avaliacoes as $avaliacao) : ?>
                                    <?php $somaTotal += $avaliacao->classificacao; ?>
                                <?php endforeach; ?>

                                <?php
                                $valorMedioReview = 0;
                                if (count($avaliacoes) > 0) {
                                    $valorMedioReview = number_format($somaTotal / count($avaliacoes), 1);
                                } ?>
                                <div class="d-flex mb-3">
                                    <small class="pt-1"></small>
                                    <div class="text-primary mr-2">
                                        <?php
                                        for ($i = 0; $i < 5; $i++) {
                                            echo '<i class="' . ($i < floor($valorMedioReview) ? 'fas' : 'far') . ' fa-star"></i>';
                                        }
                                        ?>
                                    </div>
                                    <small class="pt-1">(<?= count($avaliacoes) ?> Reviews)</small>
                                </div>
                            </div>
                            <a class="h6 text-decoration-none text-truncate"
                               href="<?= Yii::$app->urlManager->createUrl(['artigo/detail', 'id' => $artigo->id]) ?>">
                                <!-- vai criar o link, indicando o destino e mandando o id por parametro-->
                                <?= $artigo->nome ?>
                            </a>

                            <div class="d-flex align-items-center justify-content-center mt-2">
                                <h5><?= number_format($artigo->preco, 2) ?>€</h5>
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
                    <div class="product-offer mb-30" style="height: 300px;">
                        <img class="img-fluid" src="img/mochila.jpg" alt="">
                        <div class="offer-text">
                            <h3 class="text-white mb-3">A definir categoria</h3>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-md-6">
                <?php
                if ($categoriaFooter2): ?>
                <div class="product-offer mb-30" style="height: 300px;">
                    <img class="img-fluid" src="img/canecaIndex.jpg" alt="">
                    <div class="offer-text">
                        <h3 class="text-white mb-3"><?= $categoriaFooter2->nome ?></h3>
                        <a href="<?= Url::to(['artigo/categorias', 'id' => $categoriaFooter2->id]) ?>"
                           class="btn btn-primary">Shop Now</a>
                    </div>
                    <?php else: ?>
                    <div class="product-offer mb-30" style="height: 300px;">
                        <img class="img-fluid" src="img/canecaIndex.jpg" alt="">
                        <div class="offer-text">
                            <h3 class="text-white mb-3">A definir categoria</h3>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>