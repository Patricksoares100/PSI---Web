<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Ivas $model */

$this->title = 'Adicionar nova taxa de IVA';
$this->params['breadcrumbs'][] = ['label' => 'IVA\'s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ivas-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
