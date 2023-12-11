<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Perfil $model */
/** @var yii\widgets\ActiveForm $form */

$this->title = 'Alterar Password';
$this->params['breadcrumbs'][] = $this->title;
?>

<body class="perfil-alterar-password">

<div class="alterar-password-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <?= $form->field($model, 'atualPassword')->passwordInput() ?>
    </div>
    <div class="row">
        <?php echo $form->field($model, 'novaPassword')->passwordInput(); ?>
    </div>
    <div class="row">
        <?php echo $form->field($model, 'confirmarPassword')->passwordInput(); ?>
    </div>


    <div class="row submit">
        <?= Html::submitButton('Confirmar Alteração', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</body>
