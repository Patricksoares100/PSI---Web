<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Avaliacao $model */

$this->title = 'Registar Avaliação';
$this->params['breadcrumbs'][] = ['label' => 'Avaliacaos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="avaliacao-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'id' => $id,
    ]) ?>

</div>
