<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var yii\data\ActiveDataProvider $dataProvider */

use yii\helpers\Url;
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Favoritos';
$this->params['breadcrumbs'][] = $this->title;
?>

<body>

<!-- Cart Start -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-lg-8 table-responsive mb-5">
            <table class="table table-light table-borderless table-hover text-center mb-0">
                <thead class="thead-dark">
                <tr>
                    <th>Products</th>
                    <th>Preço</th>
                    <th>Carrinho</th>
                    <th>Remove</th>
                </tr>
                </thead>
                <?php foreach ($dataProvider->models as $model) : ?>
                    <tbody class="align-middle">
                    <tr>
                        <td class="align-middle"><img src="img/product-1.jpg" alt=""
                                                      style="width: 50px;"> <?= $model->artigo->nome ?>
                        </td>
                        <td class="align-middle">Product Name</td>
                        <td class="align-middle">
                            <a class="btn btn-outline-dark btn-square"
                               href="<?= Url::to(['linhacarrinho/create', 'id' => $model->artigo_id]) ?>"><i
                                        class="fa fa-shopping-cart"></i></a>    <!-- Aqui fica $model->artigo_id porque queremos o id do artigo selecionado -->
                        </td>
                        <td class="align-middle">
                            <?= Html::a('X', ['/favorito/delete', 'id' => $model->id], ['class' => 'btn btn-sm btn-danger', 'data-method' => 'post']) ?>
                        </td>
                    </tr>
                    </tbody>
                <?php endforeach; ?>
            </table>
        </div>
        <div class="col-lg-4">
            <div class="product-offer mb-30" style="height: 300px;">
                <img class="img-fluid" src="img/mochila.jpg" alt="">
                <div class="offer-text">
                    <h6 class="text-white text-uppercase">Mochilas</h6>
                    <h3 class="text-white mb-3">Aproveite as ofertas</h3>
                    <a href="" class="btn btn-primary">Compra Agora</a>
                </div>
            </div>
            <div class="product-offer mb-30" style="height: 300px;">
                <img class="img-fluid" src="img/canecaIndex.jpg" alt="">
                <div class="offer-text">
                    <h6 class="text-white text-uppercase">Canecas</h6>
                    <h3 class="text-white mb-3">Adicione ao carrinho</h3>
                    <a href="" class="btn btn-primary">Compra Agora</a>
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