<?php


namespace frontend\tests\Unit;

use common\models\Favorito;
use frontend\tests\UnitTester;

class FavoritoTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    public function testCamposObrigatorios()
    {
        $favorito = new Favorito();

        $favorito->artigo_id = null;
        $this->assertFalse($favorito->validate(['artigo_id']));

        $favorito->perfil_id = null;
        $this->assertFalse($favorito->validate(['perfil_id']));
    }
}
