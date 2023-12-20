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
<?php
$error = Yii::$app->session->getFlash('error');
if ($error) {
    echo '<div class="alert alert-danger">' . $error . '</div>';
}
?>
<div class="avaliacao-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'comentario',
            'classificacao',
            //'artigo_id',
            'artigo.nome',
            //'perfil_id',
            'perfil.nome',
            [
                'class' => ActionColumn::className(),
                'template' => Yii::$app->user->can('deleteAvaliacao') ? '{view} {update} {delete}' : '{view} {update}',
                'urlCreator' => function ($action, Avaliacao $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
