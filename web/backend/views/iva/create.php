<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Iva $model */

$this->title = 'Adicionar Iva';
$this->params['breadcrumbs'][] = ['label' => 'Ivas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="iva-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    $error = Yii::$app->session->getFlash('error');
    if ($error) {
        echo '<div class="alert alert-danger">' . $error . '</div>';
    }
    ?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>