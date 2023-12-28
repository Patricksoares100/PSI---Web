<?php


namespace frontend\tests\Unit;

use frontend\tests\UnitTester;
use common\models\Avaliacao;

class AvaliacaoTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    public function testCamposObrigatorios()
    {
        $avaliacao = new Avaliacao();

        $avaliacao->comentario = '';
        $this->assertFalse($avaliacao->validate(['comentario']));

        $avaliacao->artigo_id = '';
        $this->assertFalse($avaliacao->validate(['artigo_id']));

        $avaliacao->perfil_id = '';
        $this->assertFalse($avaliacao->validate(['perfil_id']));
    }
}
