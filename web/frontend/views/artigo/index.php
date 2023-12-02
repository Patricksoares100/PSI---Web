<?php

use app\models\Artigos;
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
<div class="artigos-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>


    <div class="container-fluid">
        <div class="row px-xl-4">
            <div class="col-lg-3 col-md-4">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filtrar por Categorias</span></h5>

                <div class="bg-light p-2 mb-20">
                    <form>
                        <?php
                        $categorias = Categoria::find()->all();
                        foreach ($dataProvider->models as $categorias) : ?>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="radio" class="custom-control-input" id="price-all<?= $categorias->categoria_id ?>" name="category" value="<?= $categorias->categoria_id ?>">
                            <label class="custom-control-label" for="price-all<?= $categorias->categoria_id ?>"><?=$categorias->nome?></label>
                        </div>
                        <?php endforeach;?>
                    </form>
                </div>

            </div>

            <!-- Shop Product Start -->
            <div class="col-lg-9 col-md-8">
                <div class="row pb-3">
                    <?php foreach ($dataProvider->models as $model) : ?> <!-- tive de colocar aqui o foreach para repetir separadamente em colunas -->
                        <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                            <div class="product-item bg-light mb-4">
                                <div class="product-img position-relative overflow-hidden">
                                    <img class="img-fluid w-100" src="img/product-2.jpg" alt="">
                                    <div class="product-action">
                                        <a class="btn btn-outline-dark btn-square" href="<?= Url::to(['linhacarrinho/create', 'id' => $model->id])?>"><i class="fa fa-shopping-cart"></i></a>
                                        <a class="btn btn-outline-dark btn-square" href="<?= Url::to(['favorito/create', 'id' => $model->id])?>"><i class="far fa-heart"></i></a>
                                    </div>
                                </div>
                                <div class="text-center py-4">
                                    <?= Html::a(Html::encode($model->nome), ['/artigo/detail', 'id' => $model->id], ['class' => 'h6 text-decoration-none text-truncate']) ?>
                                    <div class="d-flex align-items-center justify-content-center mt-2">
                                        <h5><?= number_format($model->preco ,2) ?>€</h5>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-center mb-1">
                                        <small class="fa fa-star text-primary mr-1"></small>
                                        <small class="fa fa-star text-primary mr-1"></small>
                                        <small class="fa fa-star text-primary mr-1"></small>
                                        <small class="fa fa-star text-primary mr-1"></small>
                                        <small class="fa fa-star-half-alt text-primary mr-1"></small>
                                        <small>(99)</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="col-12">
                <nav>
                    <ul class="pagination justify-content-center">
                        <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">Next</a></li>
                    </ul>
                </nav>
            </div>

        </div>
    </div>
    <!-- Shop Product End -->
</div>
</div>
<!-- Shop End -->


<!-- Back to Top -->
<a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>