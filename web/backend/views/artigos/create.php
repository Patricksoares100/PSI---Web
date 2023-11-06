<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Artigo $model */

$this->title = 'Criar novo Artigo';
$this->params['breadcrumbs'][] = ['label' => 'Artigo', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="artigos-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
