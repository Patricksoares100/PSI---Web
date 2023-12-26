<?php

namespace Tests\Unit;

use common\models\Artigo;
use Tests\Support\UnitTester;
use Codeception\Test\Unit;

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
        // Configurar dados sem preencher campos obrigatórios
        $this->artigo->imagem = '';
        $this->artigo->nome = '';
        $this->artigo->descricao = '';
        $this->artigo->referencia = '';
        $this->artigo->preco = '';
        $this->artigo->stock_atual = '';
        $this->artigo->iva_id = '';
        $this->artigo->fornecedor_id = '';
        $this->artigo->categoria_id = '';

        // Verificar se é válido
        $this->assertTrue($this->artigo->validate());

        // Verificar se há erros nos campos obrigatórios
        $this->assertTrue($this->artigo->hasErrors('imagem'), 'Deve adicionar imagem');
        $this->assertTrue($this->artigo->hasErrors('nome'), 'Deve adicionar nome');
        $this->assertTrue($this->artigo->hasErrors('descricao'), 'Deve adicionar descrição');
        $this->assertTrue($this->artigo->hasErrors('referencia'), 'Deve adicionar referência');
        $this->assertTrue($this->artigo->hasErrors('preco'), 'Deve adicionar preço');
        $this->assertTrue($this->artigo->hasErrors('stock_atual'), 'Deve adicionar uma unidade ao stock');
        $this->assertTrue($this->artigo->hasErrors('iva_id'), 'Deve adicionar um iva existente');
        $this->assertTrue($this->artigo->hasErrors('fornecedor_id'), 'Deve adicionar um fornecedor');
        $this->assertTrue($this->artigo->hasErrors('categoria_id'), 'Deve adicionar uma categoria');
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
