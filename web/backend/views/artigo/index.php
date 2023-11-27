<?php

use common\models\Artigo;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Artigos';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
$error = Yii::$app->session->getFlash('error');
if ($error) {
    echo '<div class="alert alert-danger">' . $error . '</div>';
}
?>
<div class="artigo-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Adicionar Artigo', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'nome',
            //'descricao',
            'referencia',
            'preco',
            'stock_atual' => [
                'attribute' => 'stock_atual',
                'format' => 'raw',
                'value' => function ($model) {
                    $menos = Html::a(
                        '-',
                        ['artigo/atualizarstock', 'id' => $model->id, 'sinal' => '-'],
                        ['class' => 'btn btn-danger']

                    );

                    $mais = Html::a(
                        '+',
                        ['artigo/atualizarstock', 'id' => $model->id, 'sinal' => '+'],
                        ['class' => 'btn btn-success']
                    );
                    return $menos . ' ' . $model->stock_atual . ' ' . $mais;
                },
            ],
            //'iva_id',
            //'fornecedor_id',
            //'categoria_id',
            //'perfil_id',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Artigo $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>


</div>