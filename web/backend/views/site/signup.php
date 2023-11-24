<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \frontend\models\SignupForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Registo';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Por favor preencha todos os campos para efetuar o registo:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'email') ?>

            <?= $form->field($model, 'password')->passwordInput() ?>

            <?= $form->field($model, 'nome') ?>

            <?= $form->field($model, 'telefone') ?>

            <?= $form->field($model, 'nif') ?>

            <?= $form->field($model, 'morada') ?>

            <?= $form->field($model, 'localidade') ?>

            <?= $form->field($model, 'codigo_postal')->label("Código Postal") ?>

            <?= $form->field($model, 'status')->dropDownList(['Ativo'=> 'Ativo','Inativo'=> 'Inativo']) ?>

            <div class="form-group">
                <?= Html::submitButton('Registar', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>