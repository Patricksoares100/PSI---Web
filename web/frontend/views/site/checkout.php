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
                        <input class="form-control" type="text" value="<?= $perfil->nome ?>">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Nif</label>
                        <input class="form-control" type="text" value="<?= $perfil->nif ?>">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>E-mail</label>
                        <input class="form-control" type="text" value="<?= $user->email ?>">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Telefone</label>
                        <input class="form-control" type="text" value="<?= $perfil->telefone ?> ">
                    </div>
                    <div class="col-md-12 form-group">
                        <label>Endereço</label>
                        <input class="form-control" type="text" value="<?= $perfil->morada ?>">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Localidade</label>
                        <input class="form-control" type="text" value="<?= $perfil->localidade ?>">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Codigo Postal</label>
                        <input class="form-control" type="text" value="<?= $perfil->codigo_postal ?>">
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
                </div>
                <?php
                $valorSemIva = 0;
                $valorIva = 0;
                foreach ($dataProvider->models as $model) {
                    $artigos = $model->getArtigo()->all();
                    foreach ($artigos as $artigo) {
                        if ($model->perfil_id == $userId) {
                            ?>
                            <div class="d-flex justify-content-between">
                                <p><?= $model->quantidade ?> - <?= $artigo->nome ?></p>
                                <p><?= number_format(($model->quantidade * $artigo->preco), 2) ?></p>
                            </div>
                            <?php
                            $valorSemIva += $model->quantidade * $artigo->preco;
                            $valorIva += $model->quantidade * (($artigo->iva->percentagem * $artigo->preco) / 100);
                        }
                    }
                }
                ?>
                <div class="pt-2">
                    <div class="d-flex justify-content-between mt-2">
                        <h6>Total Iva</h6>
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
                    <a href="<?= Url::to(['linhafatura/create', 'iduser' => Yii::$app->user->id]) ?>" class="btn btn-block btn-primary font-weight-bold py-3">Fazer Pagamento</a>


                </div>
            </div>
        </div>

    </div>
</div>
<!-- Checkout End -->
</body>

</html>