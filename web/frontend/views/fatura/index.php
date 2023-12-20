<?php

use common\models\Fatura;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Faturas';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="fatura-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
           // ['class' => 'yii\grid\SerialColumn'],

            //'id',
            [
                'attribute' => 'data',
                'value' => function ($model, $key, $index, $column) {
                    return $model->data;
                },
                'format' => ['date', 'php:d/m/Y']

            ],
            'valor_fatura',
            'estado',
            'perfil_id',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Fatura $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>
</div>


<!DOCTYPE html>
<html lang="en">

<body>

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
                <?php foreach ($dataProvider->models as $model) : ?>
                    <tr>
                        <td class="align-middle">
                            <i class="fas fa-paste"></i> <?=$model->id?>
                            <a href="<?= Url::to(['fatura/view', 'id' => $model->id]) ?>">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                        <td class="align-middle">
                            <div class="input-group quantity mx-auto" style="width: 100px;">
                                <?= $model->valor_fatura ?> €
                            </div>
                        </td>
                        <td class="align-middle">
                            <button class="btn btn-sm btn">
                                <?= $model->data ?>  <i class="far fa-calendar-alt fa-lg"></i>
                            </button>
                        </td>
                        <td class="align-middle">
                            <button class="btn btn-sm btn">
                                <?= $model->estado ?>
                                <i class="fas fa-clock fa-lg"></i>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    </div>
</div>

<a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>


</html>
