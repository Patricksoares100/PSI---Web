<?php

use common\models\Perfil;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Utilizadores';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="perfil-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Novo Utilizador', ['site/signup'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'nome',
            //'telefone',
            'nif',
            'role' => [
                'attribute' => 'role',
                'format' => 'raw',
                'value' => function ($model) {
                    $buttonColorClass = ($model->role == 'Funcionario') ? 'btn btn-dark' : (($model->role == 'Cliente') ? 'btn btn-light' : 'btn btn-primary disabled');
                    // ver se esta ativo ou não e dar uma cor

                    return Html::a(
                        $model->role,
                        ['perfil/atualizarrole', 'id' => $model->id],
                        ['class' => $buttonColorClass]
                    );
                },
            ],
            'status' => [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function ($model) {
                    $buttonColorClass = ($model->status == 'Ativo') ? 'btn btn-success' : 'btn btn-danger'; // ver se esta ativo ou não e dar uma cor

                    return Html::a(
                        $model->status,
                        ['perfil/atualizarstatus', 'id' => $model->id],
                        ['class' => $buttonColorClass]
                    );
                },
            ],
            //'morada',
            //'codigo_postal',
            //'localidade',
            //'carrinho_id',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Perfil $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
