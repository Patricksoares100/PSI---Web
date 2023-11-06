<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Avaliacao $model */

$this->title = 'Atualizar Avaliação: ' . $model->artigos->nome;
$this->params['breadcrumbs'][] = ['label' => 'Avaliações', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->artigos->nome, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Atualizar';
?>
<div class="avaliacaos-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
