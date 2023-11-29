<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Favorito $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="favorito-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'artigo_id')->textInput() ?>

    <?= $form->field($model, 'perfil_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
