<?php

use common\models\Avaliacao;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Avaliações';
$this->params['breadcrumbs'][] = $this->title;
?>

<div style="height: 200px; ">
    <img class="img-fluid" src="img/star.png"  alt="" >
    <div class="offer-text">
        <h3 class="text-white mb-3">As suas avaliações</h3>
    </div>
</div>

<div class="avaliacao-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'comentario',
            'classificacao',
            'artigo.nome',
            //'perfil_id',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Avaliacao $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
