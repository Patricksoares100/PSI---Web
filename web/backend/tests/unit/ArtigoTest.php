<?php

namespace backend\tests\unit;

use common\models\Artigo;
use Tests\Support\UnitTester;

class ArtigoTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;

    protected function _before()
    {
        //$this->artigo = new Artigo();
    }

    public function testCamposObrigatorios()
    {
        $artigo = new Artigo();

        // Configurar dados sem preencher campos obrigatórios
        $artigo->nome = '';
        $this->assertFalse($artigo->validate(['nome']));

        $artigo->descricao = '';
        $this->assertFalse($artigo->validate(['descricao']));

        $artigo->referencia = '';
        $this->assertFalse($artigo->validate(['referencia']));

        $artigo->preco = null;
        $this->assertFalse($artigo->validate(['preco']));

        $artigo->stock_atual = null;
        $this->assertFalse($artigo->validate(['stock_atual']));

        $artigo->iva_id = null;
        $this->assertFalse($artigo->validate(['iva_id']));

        $artigo->fornecedor_id = null;
        $this->assertFalse($artigo->validate(['fornecedor_id']));

        $artigo->categoria_id = null;
        $this->assertFalse($artigo->validate(['categoria_id']));

        $artigo->perfil_id = null;
        $this->assertFalse($artigo->validate(['perfil_id']));

        $artigo->imageFiles = [];
        $this->assertFalse($artigo->validate(['imageFiles']));
    }

    /*public function testDadosInvalidos()
    {
        // Preencher campos com dados inválidos
        $this->artigo->preco = 'abc';
        $this->artigo->stock_atual = 'def';

        // Verificar se é inválido
        $this->assertFalse($this->artigo->validate(['preco']));
        $this->assertFalse($this->artigo->validate(['stock_atual']));

        // Verificar se há um erro específico para dados inválidos no campo
        $this->assertFalse($this->artigo->hasErrors('preco'), 'Erro no campo preco para dados inválidos');
        $this->assertFalse($this->artigo->hasErrors('stock_atual'), 'Erro no campo stock atual para dados inválidos');
    }*/

    /*public function testSalvarArtigoValido()
    {

    }*/
}
