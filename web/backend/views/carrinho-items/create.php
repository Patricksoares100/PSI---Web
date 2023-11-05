<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\CarrinhoItems $model */

$this->title = 'Create Carrinho Items';
$this->params['breadcrumbs'][] = ['label' => 'Carrinho Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="carrinho-items-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
