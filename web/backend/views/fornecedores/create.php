<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Fornecedores $model */

$this->title = 'Registar Fornecedor';
$this->params['breadcrumbs'][] = ['label' => 'Fornecedores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fornecedores-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
