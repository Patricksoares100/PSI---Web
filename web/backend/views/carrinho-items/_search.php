<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\CarrinhoItemsSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="carrinho-items-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'quantidade') ?>

    <?= $form->field($model, 'valor') ?>

    <?= $form->field($model, 'valor_iva') ?>

    <?= $form->field($model, 'artigos_id') ?>

    <?php // echo $form->field($model, 'carrinhocompras_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
