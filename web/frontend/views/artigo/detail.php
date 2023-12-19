<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var \common\models\LoginForm $model */

use common\models\Artigo;
use common\models\Avaliacao;
use common\models\Perfil;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = 'Artigo';
$this->params['breadcrumbs'][] = $this->title;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>TespZorro - Loja de artigos promocionais</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">
</head>

<body>
<!-- Shop Detail Start -->
<div class="container-fluid pb-5">
    <div class="row px-xl-5">
        <div class="col-lg-5 mb-30">
            <div id="product-carousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner bg-light">
                    <div class="carousel-item active">
                        <img class="w-100 h-100" src="img/product-1.jpg" alt="Image">
                    </div>
                    <div class="carousel-item">
                        <img class="w-100 h-100" src="img/product-2.jpg" alt="Image">
                    </div>
                    <div class="carousel-item">
                        <img class="w-100 h-100" src="img/product-3.jpg" alt="Image">
                    </div>
                    <div class="carousel-item">
                        <img class="w-100 h-100" src="img/product-4.jpg" alt="Image">
                    </div>
                </div>
                <a class="carousel-control-prev" href="#product-carousel" data-slide="prev">
                    <i class="fa fa-2x fa-angle-left text-dark"></i>
                </a>
                <a class="carousel-control-next" href="#product-carousel" data-slide="next">
                    <i class="fa fa-2x fa-angle-right text-dark"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-7 h-auto mb-30">
            <div class="h-100 bg-light p-30">
                <h3><?= $model->nome ?></h3>
                <?php
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
                    <small class="pt-1"><?= $valorMedioReview ?></small>
                    <div class="text-primary mr-2">
                        <?php
                        for ($i = 0; $i < 5; $i++) {
                            echo '<i class="' . ($i < floor($valorMedioReview) ? 'fas' : 'far') . ' fa-star"></i>';
                        }
                        ?>
                    </div>


                    <small class="pt-1">(<?= count($avaliacoes) ?> Reviews)</small>
                </div>
                <h3 class="font-weight-semi-bold mb-4"><?= $model->preco ?>€</h3>
                <p class="mb-4"><?= $model->descricao ?></p>
                <div class="d-flex align-items-center mb-4 pt-2">
                    <div class="input-group quantity mr-3" style="width: 130px;">
                        <div class="input-group-btn">
                            <button class="btn btn-primary btn-minus">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                        <input type="text" class="form-control bg-secondary border-0 text-center" value="1">
                        <div class="input-group-btn">
                            <button class="btn btn-primary btn-plus">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <a class="btn btn-primary mr-4" href="<?= Url::to(['linhacarrinho/create', 'id' => $model->id]) ?>">
                        <i class="fa fa-shopping-cart mr-1"></i> Add Carrinho
                    </a>
                    <a class="btn btn-primary mr-4" href="<?= Url::to(['favorito/create', 'id' => $model->id]) ?>">
                        <i class="fa far fa-heart mr-1"></i> Add Favoritos
                    </a>
                </div>
                <div class="d-flex pt-2">
                    <strong class="text-dark mr-2">Share on:</strong>
                    <div class="d-inline-flex">
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-pinterest"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row px-xl-5">
        <?php ?>
        <div class="col">
            <div class="bg-light p-30">
                <div class="nav nav-tabs mb-4">
                    <a class="nav-item nav-link text-dark active" data-toggle="tab" href="#tab-pane-1">Reviews
                        (<?= count($avaliacoes) ?>)</a>
                </div>
                <div class="tab-pane fade show active" id="tab-pane-1">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="mb-4"> <?= count($avaliacoes) ?> Review</h4>
                            <?php if ($avaliacoes !== null) : ?>
                                <?php foreach ($avaliacoes as $avaliacao) : ?>
                                    <div class="media mb-4">
                                        <img src="img/user.jpg" alt="Image" class="img-fluid mr-3 mt-1"
                                             style="width: 45px;">
                                        <div class="media-body">
                                            <?php $utilizador = $avaliacao->perfil; ?>
                                            <?php if ($utilizador) : ?>
                                                <h6><?= $utilizador->nome ?></h6>
                                                <div class="text-primary mb-2">
                                                    <?php
                                                    $valorUnicoReview = $avaliacao->classificacao;
                                                    for ($i = 0; $i < 5; $i++) {
                                                        echo '<i class="' . ($i < floor($valorUnicoReview) ? 'fas' : 'far') . ' fa-star"></i>';
                                                    }
                                                    ?>
                                                </div>
                                                <p><?= $avaliacao->comentario ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>

                        </div>
                        <?php if (!Yii::$app->user->isGuest) { ?>
                        <div class="col-md-6">
                            <h4 class="mb-4">Leave a review</h4>
                            <small>Your email address will not be published. Required fields are marked *</small>
                            <div class="d-flex my-3">
                                <p class="mb-0 mr-2">Your Rating * :</p>
                                <div class="text-primary">
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                            </div>

                            <form method="post"
                                  action="<?= Yii::$app->urlManager->createUrl(['avaliacao/create', 'id' => $id]) ?>">
                                <?php $form = ActiveForm::begin(['id' => $id]); ?>

                                <?= $form->field($avaliacao, 'comentario')->textInput(['maxlength' => true]) ?>

                                <?= $form->field($avaliacao, 'classificacao')->dropDownList([1 => '1', 2 => '2', 3 => '3', 4 => '4', 5 => '5',], ['prompt' => '']) ?>

                                <div class="form-group">
                                    <?= Html::submitButton('Leave Your Review', ['class' => 'btn btn-primary']) ?>
                                </div>

                                <?php ActiveForm::end(); ?>
                            </form>
                            <?php } ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- Shop Detail End -->


<!-- Products Start -->
<div class="container-fluid py-5">
    <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Nossa Recomendação</span>
    </h2>
    <div class="row px-xl-5">
        <div class="col">
            <div class="owl-carousel related-carousel">
                <?php
                $modelosAleatorios = Artigo::find()->orderBy('RAND()')->limit(4)->all();
                foreach ($modelosAleatorios as $model): ?>
                    <div class="product-item bg-light">
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
                            <a class="h6 text-decoration-none text-truncate" href=""><?= $model->nome ?></a>
                            <div class="d-flex align-items-center justify-content-center mt-2">
                                <h5><?= number_format($model->preco, 2) ?></h5>
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
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <!-- Products End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>


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
</body>

</html>