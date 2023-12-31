<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var \common\models\LoginForm $model */

use common\models\Artigo;
use common\models\Avaliacao;
use common\models\Fatura;
use common\models\Imagem;
use common\models\Perfil;
use common\models\LinhaFatura;
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
                        <img class="w-100 h-100"
                             src="<?= Yii::$app->params['caminhoBackend'] . '/' . $model->imagens[0]->image_path ?>"
                             alt="Image">
                    </div>

                    <?php for ($i = 1; $i < $numeroImagens; $i++): ?>
                        <div class="carousel-item">
                            <img class="w-100 h-100"
                                 src="<?= Yii::$app->params['caminhoBackend'] . '/' . $model->imagens[$i]->image_path ?>"
                                 alt="Image">
                        </div>
                    <?php endfor; ?>

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
                foreach ($avaliacoes as $a) : ?>
                    <?php $somaTotal += $a->classificacao; ?>
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
                <h3 class="font-weight-semi-bold mb-4"><?= number_format($model->preco,2,',','.') ?>€</h3>
                <p class="mb-4"><?= $model->descricao ?></p>
                <div class="d-flex align-items-center mb-4 pt-2">
                    <div class="input-group quantity mr-3" style="width: 130px;">

                        <div class="input-group-btn">
                            <?= Html::a('-', ['adicionarcarrinho', 'id' => $model->id, 'quantidade' => $quantidade, 'sinal' => '-'], ['class' => 'btn btn-primary btn-minus', 'data-method' => 'post']) ?>
                        </div>
                        <input type="text" class="form-control bg-secondary border-0 text-center"
                               value="<?= $quantidade ?>">
                        <div class="input-group-btn">
                            <?php if ($quantidade < $model->stock_atual) {
                                echo Html::a('+', ['adicionarcarrinho', 'id' => $model->id, 'quantidade' => $quantidade, 'sinal' => '+'], ['class' => 'btn btn-primary btn-plus', 'data-method' => 'post']);
                            } else {
                                echo Html::a('+', ['adicionarcarrinho', 'id' => $model->id, 'quantidade' => $quantidade, 'sinal' => '+'], ['class' => 'btn btn-secondary disabled btn-plus', 'data-method' => 'post']);
                            } ?>
                        </div>

                    </div>
                    <?php if ($model->stock_atual > 0): ?>
                        <a class="btn btn-primary mr-4"
                           href="<?= Url::to(['linhacarrinho/create', 'id' => $model->id, 'quantidade' => $quantidade]) ?>">
                            <i class="fa fa-shopping-cart mr-1"></i> Add Carrinho
                        </a>
                    <?php else: ?>
                        <a class="btn btn-secondary disabled mr-4" href=""> Sem Stock </a>
                    <?php endif; ?>
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
                                <?php foreach ($avaliacoes as $a) : ?>
                                    <div class="media mb-4">
                                        <img src="img/user.jpg" alt="Image" class="img-fluid mr-3 mt-1"
                                             style="width: 45px;">
                                        <div class="media-body">
                                            <?php $utilizador = $a->perfil; ?>
                                            <?php if ($utilizador) : ?>
                                                <h6><?= $utilizador->nome ?></h6>
                                                <div class="text-primary mb-2">
                                                    <?php
                                                    $valorUnicoReview = $a->classificacao;
                                                    for ($i = 0; $i < 5; $i++) {
                                                        echo '<i class="' . ($i < floor($valorUnicoReview) ? 'fas' : 'far') . ' fa-star"></i>';
                                                    }
                                                    ?>
                                                </div>
                                                <p><?= $a->comentario ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <?php $artigoId = $model->id;
                            $userId = Yii::$app->user->id;
                            $faturaId = Fatura::find()->where(['perfil_id' => $userId])->one();
                            $comprouArtigo = LinhaFatura::find()->where(['artigo_id' => $artigoId, 'fatura_Id' => $faturaId])->exists();
                            ?>
                        </div>
                        <?php if (!Yii::$app->user->isGuest && $comprouArtigo) { ?>
                        <div class="col-md-6">
                            <h4 class="mb-4">Deixe uma avaliação</h4>
                            <form method="post"
                                  action="<?= Yii::$app->urlManager->createUrl(['avaliacao/create', 'id' => $id]) ?>">
                                <?php $form = ActiveForm::begin(['id' => $id]); ?>

                                <?= $form->field($avaliacao, 'comentario')->textInput(['maxlength' => true]) ?>

                                <?= $form->field($avaliacao, 'classificacao')->dropDownList([5 => '5', 4 => '4', 3 => '3', 2 => '2', 1 => '1',]) ?>

                                <div id="formAvaliacao" class="form-group">
                                    <?= Html::submitButton('Deixe a sua avaliação', ['class' => 'btn btn-primary']) ?>
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

</body>

</html>