<?php

use common\models\Empresa;
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
    $fatura = Fatura::find()->where(['perfil_id' => $userId])->one();
    $linhasFaturas = LinhaFatura::find()->where(['fatura_id' => $fatura->id])->all();
    $empresa = Empresa::find()->one();

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
            /*[
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
            ],*/
        ],
    ]) ?>

    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">

                        <!-- Main content -->
                        <div class="invoice p-3 mb-3">
                            <!-- title row -->
                            <div class="row">
                                <div class="col-12">
                                    <h4>
                                        <i class="fas fa-globe"></i> AdminLTE, Inc.
                                        <small class="float-right">Date: 2/10/2014</small>
                                    </h4>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- info row -->
                            <div class="row invoice-info">
                                <div class="col-sm-8 invoice-col">
                                    From
                                    <address>
                                        <strong><?= $empresa->nome ?></strong><br>
                                        <?= $empresa->email ?><br>
                                        <?= $empresa->telefone ?><br>
                                        <?= $empresa->nif ?><br>
                                        <?= $empresa->morada ?><br>
                                        <?= $empresa->codigo_postal ?><br>
                                        <?= $empresa->localidade ?><br>
                                    </address>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4 invoice-col">
                                    To
                                    <address>
                                        <strong><?= $perfil->nome ?></strong><br>
                                        <?= $perfil->telefone ?><br>
                                        <?= $perfil->nif ?><br>
                                        <?= $perfil->morada ?><br>
                                        <?= $perfil->codigo_postal ?><br>
                                        <?= $perfil->localidade ?><br>
                                    </address>
                                </div>
                            </div>
                            <!-- /.row -->

                            <!-- Table row -->
                            <div class="row">
                                <div class="col-12 table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>Qty</th>
                                            <th>Product</th>
                                            <th>Valor S/IVA</th>
                                            <th>Valor IVA</th>
                                            <th>Total</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($linhasFaturas as $linha): ?>
                                            <tr>
                                                <td><?= $linha->quantidade ?></td>
                                                <td><?= $linha->artigo->nome ?></td>
                                                <td><?= $linha->valor ?></td>
                                                <td><?= $linha->valor_iva ?></td>
                                                <td><?= $linha->valor + $linha->valor_iva ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <div class="row">
                                <!-- accepted payments column -->
                                <div class="col-6">

                                    <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                                    </p>
                                </div>
                                <!-- /.col -->
                                <div class="col-6">
                                    <p class="lead">Amount Due 2/22/2014</p>

                                    <div class="table-responsive">
                                        <table class="table">
                                            <tr>
                                                <th>Estado:</th>
                                                <td><?=$fatura->estado?></td>
                                            </tr>
                                            <tr>
                                                <th>Total:</th>
                                                <td><?=$fatura->valor_fatura?></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <!-- this row will not appear when printing -->
                            <div class="row no-print">
                                <div class="col-12">
                                    <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i
                                                class="fas fa-print"></i> Print</a>
                                    <button type="button" class="btn btn-success float-right"><i
                                                class="far fa-credit-card"></i> Submit
                                        Payment
                                    </button>
                                    <button type="button" class="btn btn-primary float-right"
                                            style="margin-right: 5px;">
                                        <i class="fas fa-download"></i> Generate PDF
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- /.invoice -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>

    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

</div>
