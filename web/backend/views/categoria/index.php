<?php

use common\models\Categoria;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Categorias';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
$error = Yii::$app->session->getFlash('error');
if ($error) {
    echo '<div class="alert alert-danger">' . $error . '</div>';
}
?>
<div class="categoria-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Adicionar Categoria', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'nome',
            [
                'class' => ActionColumn::className(),
                'template' => Yii::$app->user->can('deleteCategoria') ? '{view} {update} {delete}' : '{view} {update}',
                'urlCreator' => function ($action, Categoria $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
