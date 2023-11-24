<?php
$empresa = \common\models\Empresa::find()->one();
if($empresa){
$this->title = $empresa->nome;}
else{$this->title = "Insira uma empresa";}
$this->params['breadcrumbs'] = [['label' => $this->title]];
?>

<div class="row">
    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
        <?= \hail812\adminlte\widgets\SmallBox::widget([
            'title' => '150',
            'text' => 'Clientes Registados',
            'icon' => 'fas fa-shopping-cart',
        ]) ?>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
        <?php $smallBox = \hail812\adminlte\widgets\SmallBox::begin([
            'title' => '150',
            'text' => 'Funcionários Registados',
            'icon' => 'fas fa-shopping-cart',
            'theme' => 'success'
        ]) ?>
        <?php \hail812\adminlte\widgets\SmallBox::end() ?>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
        <?= \hail812\adminlte\widgets\SmallBox::widget([
            'title' => '44',
            'text' => 'Categorias Registadas',
            'icon' => 'fas fa-user-plus',
            'theme' => 'gradient-success'
        ]) ?>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
        <?= \hail812\adminlte\widgets\SmallBox::widget([
            'title' => '150',
            'text' => 'Artigos Registados',
            'icon' => 'fas fa-shopping-cart',
        ]) ?>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
        <?php $smallBox = \hail812\adminlte\widgets\SmallBox::begin([
            'title' => '150',
            'text' => 'Fornecedores Registados',
            'icon' => 'fas fa-shopping-cart',
            'theme' => 'success'
        ]) ?>
        <?php \hail812\adminlte\widgets\SmallBox::end() ?>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
        <?= \hail812\adminlte\widgets\SmallBox::widget([
            'title' => '44',
            'text' => 'Total de encomendas anual',
            'icon' => 'fas fa-user-plus',
            'theme' => 'gradient-success'
        ]) ?>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
        <?= \hail812\adminlte\widgets\SmallBox::widget([
            'title' => '150',
            'text' => 'Artigos em Carrinho',
            'icon' => 'fas fa-shopping-cart',
        ]) ?>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
        <?php $smallBox = \hail812\adminlte\widgets\SmallBox::begin([
            'title' => '150',
            'text' => 'Artigos nos favoritos',
            'icon' => 'fas fa-shopping-cart',
            'theme' => 'success'
        ]) ?>
        <?php \hail812\adminlte\widgets\SmallBox::end() ?>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
        <?= \hail812\adminlte\widgets\SmallBox::widget([
            'title' => '44',
            'text' => 'Artigo mais vendido',
            'icon' => 'fas fa-user-plus',
            'theme' => 'gradient-success'
        ]) ?>
    </div>
</div>