<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Fornecedor $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="fornecedores-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nome')->textInput(['maxlength' => true,'placeholder' => 'Nome do fornecedor']) ?>

    <?= $form->field($model, 'telefone')->textInput(['placeholder' => 'Número de telefone']) ?>

    <?= $form->field($model, 'nif')->textInput(['placeholder' => 'Número de Identificação Fiscal do fornecedor']) ?>

    <?= $form->field($model, 'morada')->textInput(['maxlength' => true, 'placeholder' => 'Morada do fornecedor']) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
