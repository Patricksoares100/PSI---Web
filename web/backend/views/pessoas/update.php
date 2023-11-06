<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Pessoa $model */

$this->title = 'Update Pessoa: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Pessoa', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pessoas-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
