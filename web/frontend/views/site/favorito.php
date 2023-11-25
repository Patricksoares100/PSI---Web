<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

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
                            <th>Quantity</th>
                            <th>Carrinho</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        <tr>
                            <td class="align-middle"><img src="img/product-1.jpg" alt="" style="width: 50px;"> Product Name</td>
                            <td class="align-middle">
                                <div class="input-group quantity mx-auto" style="width: 100px;">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-primary btn-minus">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                    <input type="text" class="form-control form-control-sm bg-secondary border-0 text-center" value="1">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-primary btn-plus">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle"><i ></i>
                                <button class="btn btn-sm btn-success">
                                    <i class="fa fa-shopping-cart"></i> <!-- Ícone do carrinho -->
                                </button>
                            <td class="align-middle">
                                <button class="btn btn-sm btn-danger">
                                    <i class="fa fa-times"></i>
                                </button>
                            </td>
                        </tr>

                    </tbody>
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