<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Avaliacaos $model */

$this->title = 'Create Avaliacaos';
$this->params['breadcrumbs'][] = ['label' => 'Avaliacaos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="avaliacaos-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
