<?php


namespace frontend\tests\Unit;

use common\models\LinhaFatura;
use frontend\tests\UnitTester;

class LinhaFaturaTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    public function testCamposObrigatorios()
    {
        $linhaFatura = new LinhaFatura();

        $linhaFatura->quantidade = null;
        $this->assertFalse($linhaFatura->validate(['quantidade']));

        $linhaFatura->valor = null;
        $this->assertFalse($linhaFatura->validate(['valor']));

        $linhaFatura->valor_iva = null;
        $this->assertFalse($linhaFatura->validate(['valor_iva']));

        $linhaFatura->artigo_id = null;
        $this->assertFalse($linhaFatura->validate(['artigo_id']));

        $linhaFatura->fatura_id = null;
        $this->assertFalse($linhaFatura->validate(['fatura_id']));
    }
}
