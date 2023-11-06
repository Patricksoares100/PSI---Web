<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\CarrinhoCompra $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="carrinho-compras-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'data')->textInput() ?>

    <?= $form->field($model, 'valor_total')->textInput() ?>

    <?= $form->field($model, 'iva_total')->textInput() ?>

    <?= $form->field($model, 'estado')->dropDownList([ 'activo' => 'Activo', 'inactivo' => 'Inactivo', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'pessoas_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
