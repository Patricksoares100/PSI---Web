<?php
$this->title = 'Starter Page';
$this->params['breadcrumbs'] = [['label' => $this->title]];
?>

<div class="row">
    <div class="col-md-4 col-sm-6 col-12">
        <?= \hail812\adminlte\widgets\InfoBox::widget([
            'text' => 'Sem mensagens de alertas Novas!',
            'number' => '410',
            'theme' => 'success',
            'icon' => 'far fa-flag',
        ]) ?>
    </div>
    <div class="col-md-4 col-sm-6 col-12">
        <?= \hail812\adminlte\widgets\InfoBox::widget([
            'text' => 'Messages',
            'number' => '1,410',
            'icon' => 'far fa-envelope',
        ]) ?>
    </div>
</div>



<div class="row">
    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
        <?= \hail812\adminlte\widgets\SmallBox::widget([
            'title' => '150',
            'text' => 'New Orders',
            'icon' => 'fas fa-shopping-cart',
        ]) ?>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
        <?php $smallBox = \hail812\adminlte\widgets\SmallBox::begin([
            'title' => '150',
            'text' => 'New Orders',
            'icon' => 'fas fa-shopping-cart',
            'theme' => 'success'
        ]) ?>
        <?php \hail812\adminlte\widgets\SmallBox::end() ?>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
        <?= \hail812\adminlte\widgets\SmallBox::widget([
            'title' => '44',
            'text' => 'Utilizadores Registados',
            'icon' => 'fas fa-user-plus',
            'theme' => 'gradient-success'
        ]) ?>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
        <?= \hail812\adminlte\widgets\SmallBox::widget([
            'title' => '150',
            'text' => 'New Orders',
            'icon' => 'fas fa-shopping-cart',
        ]) ?>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
        <?php $smallBox = \hail812\adminlte\widgets\SmallBox::begin([
            'title' => '150',
            'text' => 'New Orders',
            'icon' => 'fas fa-shopping-cart',
            'theme' => 'success'
        ]) ?>
        <?php \hail812\adminlte\widgets\SmallBox::end() ?>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
        <?= \hail812\adminlte\widgets\SmallBox::widget([
            'title' => '44',
            'text' => 'Utilizadores Registados',
            'icon' => 'fas fa-user-plus',
            'theme' => 'gradient-success'
        ]) ?>
    </div>
</div>