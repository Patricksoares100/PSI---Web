<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Avaliacao $model */
/** @var yii\widgets\ActiveForm $form */
?>
<?php $form = ActiveForm::begin(['action' => ['create', 'id' => $id]]); ?>

<?= $form->field($model, 'comentario')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'classificacao')->dropDownList([1 => '1', 2 => '2', 3 => '3', 4 => '4', 5 => '5'], ['prompt' => '']) ?>

<div class="form-group">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
