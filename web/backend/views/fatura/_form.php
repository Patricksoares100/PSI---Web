<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Fatura $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="fatura-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'data')->textInput() ?>

    <?= $form->field($model, 'valor_fatura')->textInput() ?>

    <?= $form->field($model, 'estado')->dropDownList([ 'Emitida' => 'Emitida', 'Paga' => 'Paga', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'perfil_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
