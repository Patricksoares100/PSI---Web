<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\EmpresaSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="empresa-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'nome') ?>

    <?= $form->field($model, 'email') ?>

    <?= $form->field($model, 'telefone') ?>

    <?= $form->field($model, 'nif') ?>

    <?php // echo $form->field($model, 'morada') ?>

    <?php // echo $form->field($model, 'codigo_postal') ?>

    <?php // echo $form->field($model, 'localidade') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
