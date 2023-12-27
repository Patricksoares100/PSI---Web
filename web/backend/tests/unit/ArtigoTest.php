<?php

namespace backend\tests\unit;

use common\models\Artigo;
use Tests\Support\UnitTester;

class ArtigoTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;
    private $artigo;

    protected function _before()
    {
        $this->artigo = new Artigo();
    }

    public function testCamposObrigatorios()
    {
        $artigo = new \common\models\Artigo();

        // Configurar dados sem preencher campos obrigatórios
        /*$artigo->setName(null);
        $this->assertFalse($artigo->validate(['imageFiles[]']));*/

        $artigo->nome = '';
        $this->assertFalse($artigo->validate(['nome']));

        /*$artigo->setName(null);
        $this->assertFalse($artigo->validate(['descricao']));

        $artigo->setName(null);
        $this->assertFalse($artigo->validate(['referencia[]']));

        $artigo->setName(null);
        $this->assertFalse($artigo->validate(['preco']));

        $artigo->setDescricao(null);
        $this->assertFalse($artigo->validate(['stock_atual']));

        $artigo->setName(null);
        $this->assertFalse($artigo->validate(['iva_id']));

        $artigo->setName(null);
        $this->assertFalse($artigo->validate(['fornecedor_id']));

        $artigo->setDescricao(null);
        $this->assertFalse($artigo->validate(['categoria_id']));*/

    }

    public function testDadosInvalidos()
    {
        // Preencher campos com dados inválidos
        $this->artigo->preco = 'abc';
        $this->artigo->stock_atual = 'def';

        // Verificar se é inválido
        $this->assertFalse($this->artigo->validate());

        // Verificar se há um erro específico para dados inválidos no campo
        $this->assertTrue($this->artigo->hasErrors('preco'), 'Erro no campo preco para dados inválidos');
        $this->assertTrue($this->artigo->hasErrors('stock_atual'), 'Erro no campo stock atual para dados inválidos');
    }

    /*public function testSalvarArtigoValido()
    {

    }*/
}
