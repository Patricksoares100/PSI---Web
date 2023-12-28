<?php


namespace frontend\tests\Unit;

use common\models\Fatura;
use frontend\tests\UnitTester;

class FaturaTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    // tests
    public function testCamposObrigatorios()
    {
        $fatura = new Fatura();

        $fatura->data = null;
        $this->assertFalse($fatura->validate(['data']));

        $fatura->valor_fatura = null;
        $this->assertFalse($fatura->validate(['valor_fatura']));

        $fatura->perfil_id = null;
        $this->assertFalse($fatura->validate(['perfil_id']));
    }
}
