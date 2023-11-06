<?php

use app\models\Artigo;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Artigo';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="artigos-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Novo Artigo', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'nome',
            'descricao',
            'valor',
            'stock_atual',
            'iva.percentagem',
            'fornecedores.nome',
            //'categorias.nome_categoria',
            //'pessoas.nome',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Artigo $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
