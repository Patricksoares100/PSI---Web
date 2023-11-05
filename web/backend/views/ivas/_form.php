<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Ivas $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="ivas-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'em_vigor')->dropDownList([ 'sim' => 'Sim', 'nao' => 'Não', ], ['prompt' => 'Selecione uma opção']) ?>

    <?= $form->field($model, 'descricao')->textInput(['maxlength' => true, 'placeholder' => 'Descrição da taxa de IVA']) ?>

    <?= $form->field($model, 'percentagem')->textInput(['placeholder' => 'Percentagem de 0 a 100']) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
