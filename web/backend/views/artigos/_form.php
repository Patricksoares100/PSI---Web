<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Artigo $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="artigos-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nome')->textInput(['maxlength' => true, 'placeholder' => 'Nome do artigo']) ?>

    <?= $form->field($model, 'descricao')->textInput(['maxlength' => true, 'placeholder' => 'Descrição sumária do artigo']) ?>

    <?= $form->field($model, 'valor')->textInput(['placeholder' => 'Valor unitário do artigo']) ?>

    <?= $form->field($model, 'stock_atual')->textInput(['placeholder' => 'Quantidade do artigo disponível']) ?>

    <?= $form->field($model, 'iva_id')->dropDownList(
        \yii\helpers\ArrayHelper::map(\app\models\Iva::find()->where(['em_vigor' => 'sim'])->all(), 'id', 'percentagem'),
        ['prompt' => 'Selecione o IVA']
    ) ?>
    <?= $form->field($model, 'fornecedores_id')->dropDownList(
        \yii\helpers\ArrayHelper::map(\app\models\Fornecedor::find()->all(), 'id', 'nome'),
        ['prompt' => 'Selecione o Fornecedor']
    ) ?>

    <?= $form->field($model, 'categorias_id')->dropDownList(
        \yii\helpers\ArrayHelper::map(\app\models\Categoria::find()->all(), 'id', 'nome_categoria'),
        ['prompt' => 'Selecione a Categoria']
    ) ?>

    <?= $form->field($model, 'pessoas_id')->textInput() ?> <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>