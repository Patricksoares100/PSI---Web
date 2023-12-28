
<div class="invoice p-3 mb-3">

    <div class="row">
        <div class="col-12">
            <h4>
                <i class="fas fa-globe"></i> <?= $empresa->nome ?>

            </h4>
        </div>

    </div>

    <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
            Dados da Empresa:
            <address>
                <strong><?= $empresa->nome ?></strong><br>
                Morada: <?= $empresa->morada ?><br>
                Código Postal: <?= $empresa->codigo_postal . ' <br>Localidade: ' . $empresa->localidade ?><br>
                Contato: <?= $empresa->telefone ?><br>
                Email: <?= $empresa->email ?>
            </address>
        </div>

        <div class="col-sm-4 invoice-col">
            Dados do Cliente:
            <address>
                <strong><?= $model->perfil->nome ?></strong><br>
                <?= $model->perfil->morada ?><br>
                Código Postal: <?= $model->perfil->codigo_postal . ' <br>Localidade: ' . $model->perfil->localidade ?>
                <br>
                Contato: <?= $model->perfil->telefone ?><br>
                Email: <?= $model->perfil->email ?>
            </address>
        </div>

        <div class="col-sm-4 invoice-col">
            <b></b><br>
            <br>
            <b>Encomenda Nº:</b> <?= $model->id ?><br>
            <?php
            if ($model->estado == 'Emitida'){ ?>
                <b>Data da Encomenda:</b> <?= date('d-m-Y H:i', strtotime($model->data)) ?><br>
            <?php } elseif ($model->estado == 'Paga') {?>
                <b>Data de Pagamento:</b> <?= date('d-m-Y H:i', strtotime($model->data)) ?><br>
            <?php } ?>

        </div>

    </div>


    <div class="row">
        <div class="col-12 table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>

                    <th>Qtd</th>
                    <th>Artigo</th>
                    <th>Preço</th>
                    <th>IVA</th>
                    <th>Subtotal (s/ IVA)</th>
                    <th>IVA Total</th>
                    <th>Valor Total</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $subTotalSemIva = 0;
                $ivaTotal = 0;
                foreach ($linhasFaturas as $linha) {
                    $subTotalSemIva += $linha->artigo->preco * $linha->quantidade;
                    $ivaTotal += ($linha->artigo->iva->percentagem * ($linha->artigo->preco * $linha->quantidade)) / 100; ?>
                    <tr>

                        <td><?php echo $linha->quantidade; ?></td><!-- Qtd -->
                        <td><?php echo $linha->artigo->nome; ?></td><!-- Artigo -->
                        <td><?php echo number_format($linha->artigo->preco, 2, ',', '.') . " €" ?></td><!-- preco  -->
                        <td><?php echo $linha->artigo->iva->percentagem . " %" ?></td><!-- IVA -->
                        <td><?= number_format(($linha->artigo->preco * $linha->quantidade), 2, ',', '.') . " €" ?></td>
                        <!-- Subtotal s/ iva -->
                        <td><?php echo number_format((($linha->artigo->iva->percentagem * ($linha->artigo->preco * $linha->quantidade)) / 100), 2, ',', '.') . " €" ?></td>
                        <!-- IVA TOTAL -->
                        <td><?php echo number_format((($linha->artigo->preco * $linha->quantidade) +
                                    ($linha->artigo->iva->percentagem * ($linha->artigo->preco * $linha->quantidade)) / 100), 2, ',', '.') .
                                "€" ?></td><!-- VALOR TOTAL-->
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>

    </div>

    <div class="row">

        <div class="col-6">
            <p class="lead">Payment Methods:</p>
            <img src="/img/visa.png" alt="Visa">
            <img src="/img/mastercard.png" alt="Mastercard">
            <img src="/img/american-express.png" alt="American Express">
            <img src="/img/paypal2.png" alt="Paypal">

        </div>

        <div class="col-6">
            <p class="lead"><?= date('d-m-Y', strtotime($model->data)) ?></p>
            <div class="table-responsive">
                <table class="table">
                    <tbody>
                    <tr>
                        <th style="width:50%">Subtotal:</th>
                        <td><?= number_format($subTotalSemIva, 2, ',', '.') ?> €</td>
                    </tr>
                    <tr>
                        <th>IVA Total:</th>
                        <td><?= number_format($ivaTotal, 2, ',', '.') ?> €</td>
                    </tr>

                    <tr>
                        <th>Total:</th>
                        <td><?= number_format($model->valor_fatura, 2, ',', '.') ?> €</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>