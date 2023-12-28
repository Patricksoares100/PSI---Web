<?php


namespace backend\tests\Unit;

use backend\tests\UnitTester;
use common\models\Fornecedor;

class FornecedorTest extends \Codeception\Test\Unit
{

    protected UnitTester $test;

    protected function _before()
    {
    }

    public function testCamposObrigatorios()
    {
        $fornecedor = new Fornecedor();

        $fornecedor->telefone = null;
        $this->assertFalse($fornecedor->validate(['telefone']));

        $fornecedor->nif = null;
        $this->assertFalse($fornecedor->validate(['nif']));

        $fornecedor->nome = '';
        $this->assertFalse($fornecedor->validate(['nome']));

        $fornecedor->morada = '';
        $this->assertFalse($fornecedor->validate(['morada']));
    }
}
