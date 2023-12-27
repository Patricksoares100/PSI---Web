<?php

/** @var yii\web\View $this */

use common\models\Empresa;
use yii\helpers\Html;

$this->title = 'QUEM SOMOS';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  $empresa = Empresa::find()->one()?>
    <?php if ($empresa): ?>
    <p>Nome: <?= $empresa->nome?> </p>
    <p>Email: <?= $empresa->email?> </p>
    <p>Contato: <?= $empresa->telefone?> </p>
    <p>Número de Identificação Fiscal: <?= $empresa->nif?> </p>
    <p>Morada: <?= $empresa->morada?> </p>
    <p>Código Postal: <?= $empresa->codigo_postal?> </p>
    <p>Localidade: <?= $empresa->localidade?> </p>
    <?php else: ?>
        <p>Sem empresa criada. Insira uma empresa </p>
    <?php endif; ?>

</div>
