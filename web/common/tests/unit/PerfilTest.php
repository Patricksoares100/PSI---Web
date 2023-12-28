<?php


namespace common\tests\Unit;

use common\tests\UnitTester;
use common\models\Perfil;

class PerfilTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    // tests
    public function testCamposObrigatorios()
    {
        $perfil = new Perfil();

        $perfil->nome = '';
        $this->assertFalse($perfil->validate(['nome']));

        $perfil->telefone = '';
        $this->assertFalse($perfil->validate(['telefone']));

        $perfil->nif = '';
        $this->assertFalse($perfil->validate(['nif']));

        $perfil->morada = '';
        $this->assertFalse($perfil->validate(['morada']));

        $perfil->codigo_postal = '';
        $this->assertFalse($perfil->validate(['codigo_postal']));

        $perfil->localidade = '';
        $this->assertFalse($perfil->validate(['localidade']));
    }
}
