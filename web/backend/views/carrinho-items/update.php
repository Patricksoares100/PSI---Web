<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\CarrinhoItems $model */

$this->title = 'Update Carrinho Items: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Carrinho Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="carrinho-items-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
