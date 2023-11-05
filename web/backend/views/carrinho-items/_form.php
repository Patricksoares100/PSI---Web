<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\CarrinhoItems $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="carrinho-items-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'quantidade')->textInput() ?>

    <?= $form->field($model, 'valor')->textInput() ?>

    <?= $form->field($model, 'valor_iva')->textInput() ?>

    <?= $form->field($model, 'artigos_id')->textInput() ?>

    <?= $form->field($model, 'carrinhocompras_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
