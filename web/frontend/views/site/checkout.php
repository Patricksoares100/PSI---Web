<?php

use common\models\LinhaCarrinho;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;


/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var yii\web\View $this */

$dataProvider = new ActiveDataProvider([
    'query' => LinhaCarrinho::find(),
]);


GridView::widget([
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
]);
?>
<!-- Checkout Start -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-lg-8">
            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Morada de faturação</span>
            </h5>
            <div class="bg-light p-30 mb-5">
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Primeiro Nome</label>
                        <input class="form-control" type="text" placeholder="John">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Ultimo Nome</label>
                        <input class="form-control" type="text" placeholder="Doe">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>E-mail</label>
                        <input class="form-control" type="text" placeholder="example@email.com">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Telefone/Telemovel</label>
                        <input class="form-control" type="text" placeholder="+123 456 789">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Endereço</label>
                        <input class="form-control" type="text" placeholder="123 Street">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Endereço 2 (opcional) </label>
                        <input class="form-control" type="text" placeholder="123 Street">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Localidade</label>
                        <input class="form-control" type="text" placeholder="New York">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Cidade</label>
                        <input class="form-control" type="text" placeholder="New York">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Codigo Postal</label>
                        <input class="form-control" type="text" placeholder="123">
                    </div>
                    <div class="col-md-12 form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="newaccount">
                            <label class="custom-control-label" for="newaccount">Create an account</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <h5 class="section-title position-relative text-uppercase mb-3"><span
                        class="bg-secondary pr-3">Order Total</span></h5>
            <div class="bg-light p-30 mb-5">
                <div class="border-bottom">
                    <h6 class="mb-3">Products</h6>
                    <?php
                    foreach ($dataProvider->models as $model) {
                        $artigos = $model->getArtigo()->all();
                        foreach ($artigos as $artigo) {
                            ?>
                            <div class="d-flex justify-content-between">
                                <p><?= $model->quantidade ?> - <?= $artigo->nome ?></p>
                                <p><?= number_format(($model->quantidade * $artigo->preco), 2) ?></p>
                            </div>
                        <?php }
                    } ?>
                </div>
            </div>
            <div class="border-bottom pt-3 pb-2">
                <div class="d-flex justify-content-between mb-3">
                    <h6>Valor s/iva</h6>
                    <?php $valorSemIva = 0; ?>
                    <?php foreach ($dataProvider->models as $model) {
                        $valorSemIva += $model->quantidade * $model->artigo->preco;
                    } ?>
                    <h6><?= number_format($valorSemIva, 2) ?></h6>
                </div>
                <div class="d-flex justify-content-between">
                    <h6 class="font-weight-medium">Valor Iva</h6>
                    <?php $valorIva = 0; ?>
                    <?php foreach ($dataProvider->models as $model) {
                        $valorIva += $model->quantidade * (($model->artigo->iva->percentagem * $model->artigo->preco) / 100);
                    } ?>
                    <h6 class="font-weight-medium"><?= number_format($valorIva, 2) ?></h6>
                </div>
            </div>
            <div class="pt-2">
                <div class="d-flex justify-content-between mt-2">
                    <h5>Total</h5>
                    <h5><?= number_format($valorSemIva + $valorIva, 2) ?></h5>
                </div>
            </div>
        </div>
        <div class="mb-5">
            <h5 class="section-title position-relative text-uppercase mb-3"><span
                        class="bg-secondary pr-3">Payment</span></h5>
            <div class="bg-light p-30">
                <div class="form-group">
                    <div class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input" name="payment" id="paypal">
                        <label class="custom-control-label" for="paypal">Paypal</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input" name="payment" id="directcheck">
                        <label class="custom-control-label" for="directcheck">Direct Check</label>
                    </div>
                </div>
                <div class="form-group mb-4">
                    <div class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input" name="payment" id="banktransfer">
                        <label class="custom-control-label" for="banktransfer">Bank Transfer</label>
                    </div>
                </div>
                <button class="btn btn-block btn-primary font-weight-bold py-3">Place Order</button>
            </div>
        </div>
    </div>

</div>
</div>
<!-- Checkout End -->


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