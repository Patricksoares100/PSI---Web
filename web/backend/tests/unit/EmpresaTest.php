<?php


namespace backend\tests\Unit;

use backend\tests\UnitTester;
use common\models\Empresa;

class EmpresaTest extends \Codeception\Test\Unit
{

    protected UnitTester $test;

    protected function _before()
    {
    }

    public function testCamposObrigatorios()
    {
        $empresa = new Empresa();

        $empresa->nome = '';
        $this->assertFalse($empresa->validate(['nome']));

        $empresa->email = '';
        $this->assertFalse($empresa->validate(['email']));

        $empresa->telefone = null;
        $this->assertFalse($empresa->validate(['telefone']));

        $empresa->nif = null;
        $this->assertFalse($empresa->validate(['nif']));

        $empresa->morada = '';
        $this->assertFalse($empresa->validate(['morada']));

        $empresa->codigo_postal = '';
        $this->assertFalse($empresa->validate(['codigo_postal']));

        $empresa->localidade = '';
        $this->assertFalse($empresa->validate(['localidade']));
    }
}
