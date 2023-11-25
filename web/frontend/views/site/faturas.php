<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Faturas';
$this->params['breadcrumbs'][] = $this->title;
?>

<!DOCTYPE html>
<html lang="en">

<body>

    <!-- Cart Start -->
    <div class="container-fluid">
        <div class="product-offer mb-30" style="height: 200px;">
            <img class="img-fluid" src="img/mochila.jpg" alt="">
            <div class="offer-text">
                <h6 class="text-white text-uppercase">Mochilas</h6>
                <h3 class="text-white mb-3">Ofertas Especiais</h3>
                <a href="" class="btn btn-primary">Compra Agora</a>
            </div>
        </div>
        <div class="row px-xl-5">
            <div class="col-lg-16 table-responsive mb-5">
                <table class="table table-light table-borderless table-hover text-center mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th>Fatura</th>
                            <th>Valor da Fatura</th>
                            <th>Data de Emissão</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        <tr>
                            <td class="align-middle"><i class="fas fa-paste"></i> Product Name</td>
                            <td class="align-middle"><i class="fas fa-euro-sign"></i>
                                <div class="input-group quantity mx-auto" style="width: 100px;">
                                </div>
                            </td>
                            <td class="align-middle"><button class="btn btn-sm btn">
                                    <i class="far fa-calendar-alt fa-lg"></i>
                                </button>
                            <td class="align-middle"><button class="btn btn-sm btn"><i class="fas fa-clock fa-lg"></i></button></td>
                        </tr>

                    </tbody>
                </table>

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