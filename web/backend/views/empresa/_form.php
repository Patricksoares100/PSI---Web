<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Empresa $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="empresa-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nome')->textInput(['maxlength' => true,'placeholder' => 'Nomenclatura da empresa']) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'placeholder' => 'E-mail oficial']) ?>

    <?= $form->field($model, 'telefone')->textInput(['placeholder' => 'Telefone da central']) ?>

    <?= $form->field($model, 'nif')->textInput(['placeholder' => 'Número de Identificação Fiscal "6000xxxxx"']) ?>

    <?= $form->field($model, 'morada')->textInput(['placeholder' => 'Morada Fiscal']) ?>

    <?= $form->field($model, 'codigo_postal')->textInput(['maxlength' => true,'placeholder' => '1234-567']) ?>

    <?= $form->field($model, 'localidade')->textInput(['maxlength' => true,'placeholder' => 'Leiria']) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
