<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Ivas $model */

$this->title = 'Atualizar IVA: ' . $model->descricao;
$this->params['breadcrumbs'][] = ['label' => 'IVA\'s', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->descricao, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ivas-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
