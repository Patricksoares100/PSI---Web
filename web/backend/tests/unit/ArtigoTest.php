<?php

namespace backend\tests\unit;

use common\models\Artigo;
use backend\tests\UnitTester;

class ArtigoTest extends \Codeception\Test\Unit
{
    protected UnitTester $test;

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

    public function testDadosInvalidos()
    {
        // alinea A FICHA 7
        $artigo = new Artigo();

        // Preencher campos com dados inválidos
        $artigo->preco = 'abc';
        $artigo->stock_atual = 'def';

        // Verificar se é inválido
        $this->assertFalse($artigo->validate(['preco']));
        $this->assertFalse($artigo->validate(['stock_atual']));

        // Verificar se há um erro específico para dados inválidos no campo
        /*$this->assertFalse($artigo->hasErrors('preco'), 'Erro no campo preco para dados inválidos');
        $this->assertFalse($artigo->hasErrors('stock_atual'), 'Erro no campo stock atual para dados inválidos');*/
    }

    public function testGuardarArtigoValido()
    {
        //alinea B C ficha 7
        $artigo = new Artigo();

        $artigo->nome = 'Artigo';
        $artigo->descricao = 'Descricao';
        $artigo->referencia = 'ref';
        $artigo->preco = 10.00;
        $artigo->stock_atual = 1;
        $artigo->iva_id = 1;
        $artigo->fornecedor_id = 1;
        $artigo->categoria_id = 13;
        $artigo->perfil_id = 1;
        $artigo->imageFiles = 'imagem';

        $artigo->save();

        $this->test->seeRecord('common\models\Artigo', ['descricao' => 'Descricao', 'nome' => 'Artigo']);
    //}

    //public function testUpdateArtigo(){
        // alineas D E F e G FIcha7
        //$old_artigo = $this->test->grabRecord('common\models\Artigo', ['descricao' => 'Descricao', 'nome' => 'Artigo', 'referencia' => 'ref']);

        $artigo->nome = 'ABC';
        $artigo->preco = 20.00;
        $artigo->stock_atual = 10;

        $artigo->save();
        $this->test->dontSeeRecord('common\models\Artigo', ['descricao' => 'Descricao', 'nome' => 'Artigo', 'referencia' => 'ref']);
        $this->test->seeRecord('common\models\Artigo', ['nome' => 'ABC', 'preco' => 20.00, 'referencia' => 'ref', 'stock_atual' => 10]);

        $artigo->delete();
        $this->test->dontSeeRecord('common\models\Artigo', ['descricao' => 'Descricao', 'nome' => 'ABC', 'referencia' => 'ref']);
    }
}
