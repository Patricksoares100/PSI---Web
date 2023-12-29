<?php


namespace backend\tests\unit;

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
        $categoria->scenario = 'create';

        $categoria->nome = '';
        $this->assertFalse($categoria->validate(['nome']));

        $categoria->imageFiles = [];
        $this->assertFalse($categoria->validate(['imageFiles']));
    }

    public function testDadosInvalidos()
    {
        $categoria = new Categoria();

        $categoria->nome = 123;

        //verficiar se é válido
        $this->assertFalse($categoria->validate(['nome']));
    }

    public function testGuardarCategoriaValido()
    {
        $categoria = new Categoria();

        $categoria->nome = 'Categorias';
        $categoria->imageFiles = 'imagem';

        $categoria->save();
        $this->test->seeRecord('common\models\Categoria', ['nome' => 'Categorias']);

    }

    public function testUpdateCategoria()
    {
        // vai procurar na BD
        $categoria = $this->test->grabRecord('common\models\Categoria', ['nome' => 'Canetas']);

        //vai gravar a alteração
        $categoria->nome = 'Update';
        $this->assertTrue($categoria->save());

        //vai verificar se encontra a alteração do update na BD
        $this->test->dontSeeRecord('common\models\Categoria', ['nome' => 'Canetas']);
        $this->test->seeRecord('common\models\Categoria', ['nome' => 'Update']);

        //vai apagar o registo da base de dados
        $categoria->delete();

        // vai verificar se o registo já nao se encotra na base de dados
        $this->test->dontSeeRecord('common\models\Categoria', ['nome' => 'Update']);
    }
}
