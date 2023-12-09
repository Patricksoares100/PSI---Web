<?php

use common\models\LinhaCarrinho;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Linha Carrinhos';
$this->params['breadcrumbs'][] = $this->title;
?>

<!-- <div class="linha-carrinho-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Linha Carrinho', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'id',
        'quantidade',
        'artigo_id',
        'perfil_id',
        [
            'class' => ActionColumn::className(),
            'urlCreator' => function ($action, LinhaCarrinho $model, $key, $index, $column) {
                return Url::toRoute([$action, 'id' => $model->id]);
            }
        ],
    ],
]); ?>

</div>-->

<!DOCTYPE html>
<html lang="en">

<body>

<!-- Cart Start -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-lg-9 table-responsive mb-5">
            <table class="table table-light table-borderless table-hover text-center mb-0">
                <thead class="thead-dark">
                <tr>
                    <th>Produto</th>
                    <th>Nome</th>
                    <th>Preço</th>
                    <th>% IVA</th>
                    <th>Valor IVA</th>
                    <th>Quantidade</th>
                    <th>Total</th>
                    <th>Remover</th>
                </tr>
                </thead>
                <?php foreach ($dataProvider->models as $model) : ?>
                    <tbody class="align-middle">
                    <tr>
                        <td class="align-middle"><img src="img/product-1.jpg" alt="" style="width: 50px;"></td>
                        <td class="align-middle"><?= $model->artigo->nome ?> </td>
                        <td class="align-middle"><?= $model->artigo->preco ?> €</td>
                        <!-- vai buscar ao modelo o getArtigo - MASTER DETAIL-->
                        <td class="align-middle"><?= $model->artigo->iva->percentagem ?> %</td>
                        <td class="align-middle"><?= number_format(($model->artigo->iva->percentagem * $model->artigo->preco) / 100, 2) ?>
                            €
                        </td>
                        <td class="align-middle">
                            <div class="input-group quantity mx-auto" style="width: 100px;">
                                <div class="input-group-btn">

                                    <?= Html::a('-', ['/linhacarrinho/update', 'id' => $model->id, 'sinal' => '-'], ['class' => 'btn btn-sm btn-primary btn-minus', 'data-method' => 'post']) ?>

                                </div>
                                <input type="text"
                                       class="form-control form-control-sm bg-secondary border-0 text-center"
                                       value="<?= $model->quantidade ?>">
                                <div class="input-group-btn">

                                    <?= Html::a('+', ['/linhacarrinho/update', 'id' => $model->id, 'sinal' => '+'], ['class' => 'btn btn-sm btn-primary btn-plus', 'data-method' => 'post']) ?>

                                </div>
                            </div>
                        </td>
                        <td class="align-middle"><?= number_format($model->quantidade * ($model->artigo->preco + (($model->artigo->iva->percentagem * $model->artigo->preco) / 100)), 2) ?>
                            €
                        </td>
                        <td class="align-middle">
                            <?= Html::a('X', ['/linhacarrinho/delete', 'id' => $model->id], ['class' => 'btn btn-sm btn-danger', 'data-method' => 'post']) ?>
                        </td>
                    </tr>
                    </tbody>
                <?php endforeach; ?>
            </table>
        </div>
        <div class="col-lg-3">
            <h5 class="section-title position-relative text-uppercase mb-3"><span
                        class="bg-secondary pr-3">Cart Summary</span></h5>
            <div class="bg-light p-30 mb-5">
                <div class="border-bottom pb-2">
                    <div class="d-flex justify-content-between mb-3">
                        <h6>Total s/ IVA</h6>
                        <?php
                        $valorTotal = 0;
                        foreach ($dataProvider->models as $model) : ?>
                            <?php
                            $valorTotal += $model->quantidade * $model->artigo->preco;
                            ?>
                        <?php endforeach; ?>
                        <h6><?= $valorTotal ?></h6>

                    </div>
                    <div class="d-flex justify-content-between">
                        <h6 class="font-weight-medium">Valor IVA</h6>
                        <?php
                        $totalIvas = 0;
                        foreach ($dataProvider->models as $model) : ?>
                            <?php
                            $totalIvas += $model->quantidade * (($model->artigo->iva->percentagem * $model->artigo->preco) / 100);
                            ?>
                        <?php endforeach; ?>
                        <h6 class="font-weight-medium"><?= number_format($totalIvas, 2) ?></h6>
                    </div>
                </div>
                <div class="pt-2">
                    <div class="d-flex justify-content-between mt-2">
                        <h5>Total</h5>
                        <h5><?= number_format($totalIvas + $valorTotal, 2) ?></h5>
                    </div>
                    <?php foreach ($dataProvider->models as $model) : ?>
                    <a href="<?= Url::to(['/site/checkout','id' => $model->id]) ?>"
                       class="btn btn-block btn-primary font-weight-bold my-3 py-3">Proceed To Checkout</a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Cart End -->


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