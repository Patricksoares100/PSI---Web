<?php

if ($empresa) {
    $this->title = $empresa->nome;
} else {
    $this->title = "Insira uma empresa";
}
$this->params['breadcrumbs'] = [['label' => $this->title]];
?>
<?php
$error = Yii::$app->session->getFlash('error');
if ($error) {
    echo '<div class="alert alert-danger">' . $error . '</div>';
}
?>

<div class="row">
    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
        <?= \hail812\adminlte\widgets\SmallBox::widget([
            'title' => $numeroClientes,
            'text' => 'Clientes Registados',
            'icon' => 'fas fa-users',
        ]) ?>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
        <?php $smallBox = \hail812\adminlte\widgets\SmallBox::begin([
            'title' => $numeroFuncionarios,
            'text' => 'Funcionários Registados',
            'icon' => 'fas fa-user',
            'theme' => 'success'
        ]) ?>
        <?php \hail812\adminlte\widgets\SmallBox::end() ?>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
        <?= \hail812\adminlte\widgets\SmallBox::widget([
            'title' => $numeroCategorias,
            'text' => 'Categorias Registadas',
            'icon' => 'fas fa-user-plus',
            'theme' => 'gradient-success'
        ]) ?>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
        <?= \hail812\adminlte\widgets\SmallBox::widget([
            'title' => $numeroArtigos,
            'text' => 'Artigos Registados',
            'icon' => 'fas fa-shopping-cart',
        ]) ?>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
        <?php $smallBox = \hail812\adminlte\widgets\SmallBox::begin([
            'title' => $numeroFornecedores,
            'text' => 'Fornecedores Registados',
            'icon' => 'fas fa-shopping-cart',
            'theme' => 'success'
        ]) ?>
        <?php \hail812\adminlte\widgets\SmallBox::end() ?>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
        <?= \hail812\adminlte\widgets\SmallBox::widget([
            'title' => 'XXX',
            'text' => 'Total de encomendas anual',
            'icon' => 'fas fa-shopping-cart',
            'theme' => 'gradient-success'
        ]) ?>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
        <?= \hail812\adminlte\widgets\SmallBox::widget([
            'title' => 'XXX',
            'text' => 'Artigos em Carrinho',
            'icon' => 'fas fa-shopping-cart',
        ]) ?>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
        <?php $smallBox = \hail812\adminlte\widgets\SmallBox::begin([
            'title' => 'XXX',
            'text' => 'Artigos nos favoritos',
            'icon' => 'fas fa-shopping-cart',
            'theme' => 'success'
        ]) ?>
        <?php \hail812\adminlte\widgets\SmallBox::end() ?>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
        <?= \hail812\adminlte\widgets\SmallBox::widget([
            'title' => 'XXX',
            'text' => 'Artigo mais vendido',
            'icon' => 'fas fa-user-plus',
            'theme' => 'gradient-success'
        ]) ?>
    </div>
</div>