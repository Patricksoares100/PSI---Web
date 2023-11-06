<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Pessoa $model */

$this->title = 'Create Pessoa';
$this->params['breadcrumbs'][] = ['label' => 'Pessoa', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pessoas-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
