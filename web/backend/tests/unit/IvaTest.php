<?php

namespace backend\tests\Unit;

use backend\tests\UnitTester;
use common\models\Iva;

class IvaTest extends \Codeception\Test\Unit
{

    protected UnitTester $test;

    protected function _before()
    {
    }

    public function testCamposObrigatorios()
    {
        $iva = new Iva();

        $iva->em_vigor = '';
        $this->assertFalse($iva->validate(['em_vigor']));

        $iva->descricao = '';
        $this->assertFalse($iva->validate(['descricao']));

        $iva->percentagem = null;
        $this->assertFalse($iva->validate(['percentagem']));
    }

    public function testGuardarArtigoValido()
    {
        $iva = new Iva();

        $iva->em_vigor = 'Sim';
        $iva->percentagem = 10;
        $iva->descricao = 'ref';


        $iva->save();

        $this->test->seeRecord('common\models\Iva', ['percentagem' => 10, 'descricao' => 'ref']);


    }
}
