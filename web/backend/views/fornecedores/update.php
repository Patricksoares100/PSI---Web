<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Fornecedor $model */

$this->title = 'Atualizar Fornecedor: ' . $model->nome;
$this->params['breadcrumbs'][] = ['label' => 'Fornecedor', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nome, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Atualizar';
?>
<div class="fornecedores-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
