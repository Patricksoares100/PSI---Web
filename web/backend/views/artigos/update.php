<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Artigo $model */

$this->title = 'Atualizar Artigo: ' . $model->nome;
$this->params['breadcrumbs'][] = ['label' => 'Artigo', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nome, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="artigos-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
