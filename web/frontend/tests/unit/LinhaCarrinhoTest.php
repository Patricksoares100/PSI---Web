<?php


namespace frontend\tests\Unit;

use common\models\LinhaCarrinho;
use frontend\tests\UnitTester;

class LinhaCarrinhoTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    public function testCamposObrigatorios()
    {
        $linhaCarrinho = new LinhaCarrinho();

        $linhaCarrinho->quantidade = null;
        $this->assertFalse($linhaCarrinho->validate(['quantidade']));

        $linhaCarrinho->artigo_id = null;
        $this->assertFalse($linhaCarrinho->validate(['artigo_id']));

        $linhaCarrinho->perfil_id = null;
        $this->assertFalse($linhaCarrinho->validate(['perfil_id']));
    }
}
