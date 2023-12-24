<?php

use app\models\Artigos;
use common\models\Avaliacao;
use common\models\Categoria;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\ArtigoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Artigos';
$this->params['breadcrumbs'][] = $this->title;
?>

    <div class="container-fluid">
        <div class="row px-xl-4">
            <div class="col-lg-12 col-md-8">
                <div class="row pb-3">
                    <?php foreach ($dataProvider->models as $model) : ?> <!-- tive de colocar aqui o foreach para repetir separadamente em colunas -->
                        <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                            <div class="product-item bg-light mb-4">
                                <div class="product-img position-relative overflow-hidden">
                                    <img class="img-fluid w-100" src="<?=Yii::$app->params['caminhoBackend']. '/'. $model->imagens[0]->image_path?>" style="width: 5cm; height: 5cm;"  alt="Imagem do artigo">
                                    <div class="product-action">
                                        <?php if ($model->stock_atual > 0): ?>
                                        <a class="btn btn-outline-dark btn-square" href="<?= Url::to(['linhacarrinho/create', 'id' => $model->id])?>"><i class="fa fa-shopping-cart"></i></a>
                                        <?php endif; ?>
                                        <a class="btn btn-outline-dark btn-square" href="<?= Url::to(['favorito/create', 'id' => $model->id])?>"><i class="far fa-heart"></i></a>
                                    </div>
                                </div>
                                <div class="text-center py-4">
                                    <?= Html::a(Html::encode($model->nome), ['/artigo/detail', 'id' => $model->id], ['class' => 'h6 text-decoration-none text-truncate']) ?>
                                    <div class="d-flex align-items-center justify-content-center mt-2">
                                        <h5><?= number_format($model->preco, 2) ?>€</h5>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-center mb-1">
                                    <?php
                                    $avaliacoes = Avaliacao::find()->where(['artigo_id' => $model->id])->all();
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <!-- <div class="col-12">
                <nav>
                    <ul class="pagination justify-content-center">
                        <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">Next</a></li>
                    </ul>
                </nav>
            </div>-->

        </div>
    </div>
    <!-- Shop Product End -->
</div>
</div>
<!-- Shop End -->


<!-- Back to Top -->
<a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>