<?php

use common\models\Empresa;
use common\models\Perfil;

?>


<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <?php $empresa = Empresa::find()->one();?>
    <a href="<?= Yii::$app->urlManager->createUrl(['empresa/view', 'id' => $empresa ? $empresa->id : null]) ?>" class="brand-link">
        <img src="<?= $assetDir ?>/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <?php if ($empresa){?>
        <span class="brand-text font-weight-light"><?= $empresa->nome ?></span>
        <?php }else { ?>
        <span class="brand-text font-weight-light">Insira uma empresa</span>
        <?php } ?>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->

        <?php
        $userId = Yii::$app->user->id;
        $perfil = Perfil::find()->where(['id' => $userId])->one();
        ?>
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?= $assetDir ?>/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="<?= Yii::$app->urlManager->createUrl(['perfil/view', 'id' => $perfil->id]) ?>" class="d-block"><?= Yii::$app->user->identity->username ?></a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <!-- href be escaped -->
        <!-- <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div> -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <?php
            echo \hail812\adminlte\widgets\Menu::widget([
                'items' => [

                    [
                        'label' => 'Artigos',
                        'icon' => 'th',
                        'badge' => '<span class="right badge badge-info"></span>',
                        'items' => [
                            ['label' => 'Ver todos', 'url' => ['artigo/index'], 'iconStyle' => 'far'],
                            ['label' => 'Criar Artigo', 'url' => ['artigo/create'], 'iconStyle' => 'far'],
                        ]
                    ],

                    [
                        'label' => 'Fornecedores',
                        'icon' => 'file-code',
                        'badge' => '<span class="right badge badge-info"></span>',
                        'items' => [
                            ['label' => 'Ver Fornecedores', 'url' => ['fornecedor/index'], 'iconStyle' => 'far'],
                            ['label' => 'Adicionar', 'url' => ['fornecedor/create'], 'iconStyle' => 'far'],
                        ]
                    ],


                    [
                        'label' => 'Ivas',
                        'icon' => 'th',
                        'badge' => '<span class="right badge badge-info"></span>',
                        'items' => [
                            ['label' => 'Ver todos', 'url' => ['iva/index'], 'iconStyle' => 'far'],
                            ['label' => 'Criar Iva', 'url' => ['iva/create'], 'iconStyle' => 'far'],
                        ]
                    ],
                    [
                        'label' => 'Categorias',
                        'icon' => 'file-code',
                        'badge' => '<span class="right badge badge-info"></span>',
                        'items' => [
                            ['label' => 'Ver todas', 'url' => ['categoria/index'], 'iconStyle' => 'far'],
                            ['label' => 'Adicionar', 'url' => ['categoria/create'], 'iconStyle' => 'far'],
                        ]
                    ],

                    [
                        'label' => 'Faturas/Pedidos',
                        'icon' => 'th',
                        'badge' => '<span class="right badge badge-info"></span>',
                        'items' => [
                            ['label' => 'Ver todas', 'url' => ['fatura/index'], 'iconStyle' => 'far'],
                        ]
                    ],

                    [
                        'label' => 'Avaliações',
                        'icon' => 'th',
                        'badge' => '<span class="right badge badge-info"></span>',
                        'items' => [
                            ['label' => 'Ver todas', 'url' => ['avaliacao/index'], 'iconStyle' => 'far'],
                        ]
                    ],

                    // linha de separador
                    ['label' => 'Empresa', 'header' => true],

                    [
                        'label' => 'Empresa',
                        'icon' => 'tachometer-alt',
                        'badge' => '<span class="right badge badge-info"></span>',
                        'items' => [
                            ['label' => 'Ver dados', 'url' => ['empresa/index'], 'iconStyle' => 'far'],
                        ]
                    ],

                    [
                        'label' => 'Utilizadores',
                        'icon' => 'tachometer-alt',
                        'badge' => '<span class="right badge badge-info"></span>',
                        'items' => [
                            ['label' => 'Ver Utilizadores', 'url' => ['perfil/index'], 'iconStyle' => 'far'],
                            ['label' => 'Criar Novo', 'url' => ['site/signup'], 'iconStyle' => 'far'],
                            ['label' => 'Atualizar dados pesoais', 'url' => ['perfil/update', 'id' => Yii::$app->user->identity->id], 'iconStyle' => 'far'],
                            ['label' => 'Visualizar dados pessoais', 'url' => ['perfil/view', 'id' => Yii::$app->user->identity->id], 'iconStyle' => 'far'],
                            ['label' => 'Alterar Password', 'url' => ['perfil/alterar-password', 'id' => Yii::$app->user->identity->id], 'iconStyle' => 'far'],
                        ]
                    ],
                ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>