<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Avaliacaos $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="avaliacaos-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'comentario')->textInput(['maxlength' => true, 'placeholder' => 'Insira o seu comentário']) ?>

    <?= $form->field($model, 'classificacao')->dropDownList([1 => '1', 2 => '2', 3 => '3', 4 => '4', 5 => '5',], ['prompt' => 'Selecione uma opção']) ?>


    <?= $form->field($model, 'artigos_id')->dropDownList(
        \yii\helpers\ArrayHelper::map(\app\models\Artigos::find()->all(), 'id', 'nome'),
        ['prompt' => 'Selecione um artigo']) ?>

    <?=//tem que se fazer isto automatico com o gajo que estiver logado 
        $form->field($model, 'pessoas_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>