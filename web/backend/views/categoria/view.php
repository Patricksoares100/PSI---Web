<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Categoria $model */

$this->title = $model->nome;
$this->params['breadcrumbs'][] = ['label' => 'Categorias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="categoria-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Atualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Remover', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Deseja realmente remover este item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'nome',
            [
                'attribute' => 'imagem.image_path',
                'format' => 'html',
                'value' => function ($model) {
                    if (!empty($model->imagens)) {
                        $html = '';
                        foreach ($model->imagens as $imagem) {
                            $html .= '<img src="' .
                                Yii::getAlias('@web/' . $imagem->image_path) .
                                '" alt="Imagem da Categoria" style="width: 5cm; height: 5cm;">';
                        }
                        return $html;
                    } else {
                        return 'Não existem imagens associadas';
                    }
                },
            ],
        ],
    ]) ?>

</div>
