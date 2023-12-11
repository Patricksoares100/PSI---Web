<?php

use common\models\LinhaCarrinho;
use common\models\Perfil;
use common\models\User;
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
<?php
$userId = Yii::$app->user->id; // vai receber o ID do utilizador logado
$perfil = Perfil::find()->where(['id' => $userId])->one();
$user = User::find()->where(['id' => $userId])->one();
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
                        <input class="form-control" type="text" value="<?= $perfil->nome?>" >
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Nif</label>
                        <input class="form-control" type="text" value="<?=$perfil->nif?>">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>E-mail</label>
                        <input class="form-control" type="text" value="<?=$user->email?>">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Telefone</label>
                        <input class="form-control" type="text" value="<?=$perfil->telefone?> ">
                    </div>
                    <div class="col-md-12 form-group">
                        <label>Endereço</label>
                        <input class="form-control" type="text" value="<?=$perfil->morada?>">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Localidade</label>
                        <input class="form-control" type="text" value="<?=$perfil->localidade?>">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Codigo Postal</label>
                        <input class="form-control" type="text" value="<?=$perfil->codigo_postal ?>">
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
                <a href="<?= Url::to(['fatura/index','id' => $model->id]) ?>" class="btn btn-block btn-primary font-weight-bold py-3">Fazer Pagamento</a>
            </div>
        </div>
    </div>

</div>
</div>
<!-- Checkout End -->
</body>

</html>