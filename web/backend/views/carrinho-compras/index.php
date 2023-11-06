<?php

use app\models\CarrinhoCompra;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Carrinho Compras';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="carrinho-compras-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Carrinho Compras', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'data',
            'valor_total',
            'iva_total',
            'estado',
            //'pessoas_id',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, CarrinhoCompra $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
