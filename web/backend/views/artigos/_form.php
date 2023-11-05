<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Artigos $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="artigos-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descricao')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'valor')->textInput() ?>

    <?= $form->field($model, 'stock_atual')->textInput() ?>

    <?= $form->field($model, 'iva_id')->textInput() ?>

    <?= $form->field($model, 'fornecedores_id')->textInput() ?>

    <?= $form->field($model, 'categorias_id')->textInput() ?>

    <?= $form->field($model, 'pessoas_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
