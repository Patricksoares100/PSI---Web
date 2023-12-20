<?php

use common\models\Iva;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Taxas de Iva';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
$error = Yii::$app->session->getFlash('error');
if ($error) {
    echo '<div class="alert alert-danger">' . $error . '</div>';
}
?>
<div class="iva-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Adicionar Iva', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'em_vigor' => [
                'attribute' => 'em_vigor',
                'format' => 'raw',
                'value' => function ($model) {
                    $buttonColorClass = ($model->em_vigor == 'Sim') ? 'btn btn-success' : 'btn btn-danger'; // ver se esta ativo ou não e dar uma cor

                    return Html::a(
                        $model->em_vigor,
                        ['iva/atualizarvigor', 'id' => $model->id],
                        ['class' => $buttonColorClass]
                    );
                },
            ],
            'descricao',
            'percentagem',
            [
                'class' => ActionColumn::className(),
                'template' => Yii::$app->user->can('deleteIva') ? '{view} {update} {delete}' : '{view} {update}',
                'urlCreator' => function ($action, Iva $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>


</div>