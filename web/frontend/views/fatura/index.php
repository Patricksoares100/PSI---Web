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
                'format' => ['date', 'php:d/m/Y H:i']

            ],
            'valor_fatura',
            'estado',
            //'perfil.nome',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Fatura $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 },
                'template' => '{view} {delete}',
                'visibleButtons' => [
                    'delete' => function ($model) {
                        return $model->estado == 'Emitida';
                    },
                ]
            ],
        ],
    ]); ?>
</div>

