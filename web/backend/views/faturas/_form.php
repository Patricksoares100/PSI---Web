<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Faturas $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="faturas-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'data')->textInput() ?>

    <?= $form->field($model, 'valor_fatura')->textInput() ?>

    <?= $form->field($model, 'estado')->dropDownList([ 'emitida' => 'Emitida', 'paga' => 'Paga', 'cancelada' => 'Cancelada', ], ['prompt' => '']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
