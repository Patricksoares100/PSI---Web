<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Avaliacao $model */

$this->title = 'Registar Avaliação';
$this->params['breadcrumbs'][] = ['label' => 'Avaliações', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="avaliacaos-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
