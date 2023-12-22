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
<?php
$error = Yii::$app->session->getFlash('error');
if ($error) {
    echo '<div class="alert alert-danger">' . $error . '</div>';
}
?>
<div class="fatura-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'data',
            'valor_fatura',
            'estado' => [
                'attribute' => 'estado',
                'format' => 'raw',
                'value' => function ($model) {
                    $buttonColorClass = ($model->estado == 'Emitida') ? 'btn btn-danger' : 'btn btn-success'; // ver se esta ativo ou não e dar uma cor

                    if ($model->estado == 'Emitida'){
                        return Html::a(
                            $model->estado,
                            ['atualizarstatus', 'id' => $model->id],
                            ['class' => $buttonColorClass]
                        );
                    }
                    return $model->estado;
                },
            ],
            'perfil.nome',
            [
                'class' => ActionColumn::className(),
                'template' => Yii::$app->user->can('deleteFatura') ? '{view} {update} {delete}' : '{view} {update}',
                'urlCreator' => function ($action, Fatura $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                },
                //https://stackoverflow.com/questions/27142206/hide-yii2-gridview-action-buttons
                'visibleButtons' => [
                    'update' => function ($model) {
                        return $model->estado != 'Paga';
                    },
                    'delete' => function ($model) {
                        return $model->estado != 'Paga';
                    },
                ]
            ],
        ],
    ]); ?>


</div>
