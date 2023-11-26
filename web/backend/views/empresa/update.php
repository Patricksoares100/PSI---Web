<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Empresa $model */

$this->title = 'Atualizar dados da empresa: ' . $model->nome;
$this->params['breadcrumbs'][] = ['label' => 'Empresa', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nome, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Atualizar';
?>
<div class="empresa-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
