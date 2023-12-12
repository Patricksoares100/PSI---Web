<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Perfil $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="perfil-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'username')->textInput(['value' => $model->getUsername()]) ?>

    <?= $form->field($model, 'email')->textInput(['value' => $model->getEmail()]) ?>

    <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'telefone')->textInput() ?>

    <?= $form->field($model, 'nif')->textInput() ?>

    <?= $form->field($model, 'morada')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'codigo_postal')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'localidade')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'role')->dropDownList(['Funcionario' => 'Funcionário', 'Cliente' => 'Cliente', 'Admin' => 'Admin']) ?>

    <?= $form->field($model, 'status')->dropDownList([$model->getStatusNumber() => $model->getStatus(), 10 => 'Ativo', 9 => 'Inativo']) ?>


    <div class="form-group">
        <a class="btn btn-outline-dark btn-square"
           href="<?= Url::to(['perfil/alterar-password', 'id' => $model->id]) ?>"><i
                    class="fa fa-key"></i> Alterar Password</a>
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
