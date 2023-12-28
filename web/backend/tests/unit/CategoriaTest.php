<?php


namespace backend\tests\Unit;

use backend\tests\UnitTester;
use common\models\Categoria;

class CategoriaTest extends \Codeception\Test\Unit
{

    protected UnitTester $test;

    protected function _before()
    {
    }

        public function testCamposObrigatorios()
    {
        $categoria = new Categoria();

        $categoria->nome = '';
        $this->assertFalse($categoria->validate(['nome']));

        $categoria->imageFiles = [];
        $this->assertFalse($categoria->validate(['imageFiles']));
    }
}
