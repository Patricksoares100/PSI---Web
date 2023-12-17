<?php

use common\models\Fatura;
use common\models\LinhaCarrinho;
use common\models\LinhaFatura;
use common\models\Perfil;
use common\models\User;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Fatura $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Faturas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="fatura-view">

    <?php /*
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
 */ ?>

    <?php
    $userId = Yii::$app->user->id;
    $perfil = Perfil::find()->where(['id' => $userId])->one();
    $user = User::find()->where(['id' => $userId])->one();
    $linhaCarrinho = LinhaCarrinho::find()->where(['perfil_id' => $userId])->one();
    $faturas = Fatura::find()->where(['perfil_id' => $userId])->all();
    ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'data',
            'valor_fatura',
            'estado',
            //'perfil_id',
            [
                'label' => 'Primeiro Nome',
                'value' => $perfil->nome,
            ],
            [
                'label' => 'Nif',
                'value' => $perfil->nif,
            ],
            [
                'label' => 'E-mail',
                'value' => $user->email,
            ],
            [
                'label' => 'Telefone',
                'value' => $perfil->telefone,
            ],
            [
                'label' => 'Endereço',
                'value' => $perfil->morada,
            ],
            [
                'label' => 'Localidade',
                'value' => $perfil->localidade,
            ],
            [
                'label' => 'Codigo Postal',
                'value' => $perfil->codigo_postal,
            ],
            /// agora
            [
                'label' => 'Artigos',
                'value' => $linhaCarrinho->artigo->nome,
            ],
            [
                'label' => 'Artigos',
                'value' => $linhaCarrinho->artigo_id,
            ],
            [
                'label' => 'Quantidade',
                'value' => $linhaCarrinho->quantidade,
            ],
        ],
    ]) ?>

</div>
