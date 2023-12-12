<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Artigo $model */

$this->title = 'Atualizar Artigo: ' . $model->nome;
$this->params['breadcrumbs'][] = ['label' => 'Artigos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nome, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Atualizar';
?>
<div class="artigo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'fornecedores' =>$fornecedores,
        'ivas'=>$ivas,
        'categorias'=>$categorias,
    ]) ?>

</div>