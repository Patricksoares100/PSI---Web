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
        $artigo->scenario = 'create';

        // A - Despoletar todas as regras de validação (introduzindo dados erróneos);
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
        //
        $artigo = new Artigo();

        // A- Despoletar todas as regras de validação (introduzindo dados erróneos);
        // Validar int
        $artigo->preco = 'abc';
        $artigo->stock_atual = 'def';
        // Validar max 255 caracteres
        $artigo->nome ='tolongnmmmameeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee';
        $artigo->descricao ='tolongnmmmameeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee';
        $artigo->referencia ='tolongnmmmameeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee';

        // Verificar se é inválido
        $this->assertFalse($artigo->validate(['preco']));
        $this->assertFalse($artigo->validate(['stock_atual']));
        $this->assertFalse($artigo->validate(['nome']));
        $this->assertFalse($artigo->validate(['descricao']));
        $this->assertFalse($artigo->validate(['referencia']));

        // Verificar se há um erro específico para dados inválidos no campo
        /*$this->assertFalse($artigo->hasErrors('preco'), 'Erro no campo preco para dados inválidos');
        $this->assertFalse($artigo->hasErrors('stock_atual'), 'Erro no campo stock atual para dados inválidos');*/
    }

    public function testGuardarArtigoValido()
    {
        //B - Criar um registo válido e guardar na BD
        $artigo = new Artigo();

        $artigo->nome = 'Artigo';
        $artigo->descricao = 'Descricao';
        $artigo->referencia = 'ref';
        $artigo->preco = 10.00;
        $artigo->stock_atual = 1;
        $artigo->iva_id = 1;
        $artigo->fornecedor_id = 1;
        $artigo->categoria_id = 1;
        $artigo->perfil_id = 1;
        $artigo->imageFiles = 'imagem';

        $this->assertTrue($artigo->save());
        //C - Ver se o registo válido se encontra na BD
        $this->test->seeRecord('common\models\Artigo', ['descricao' => 'Descricao', 'nome' => 'Artigo']);
    }

    public function testUpdateArtigo(){
        // alineas D E F e G FIcha7
        //D - Ler o registo anterior e aplicar um update
        $artigo = $this->test->grabRecord('common\models\Artigo', ['descricao' => 'Caneta Preta Potente', 'nome' => 'Caneta Aluminio', 'referencia' => 'CAN001']);

        $artigo->nome = 'Update';
        $artigo->preco = 20.00;
        $artigo->stock_atual = 10;

        $this->assertTrue($artigo->save());

        //E - Ver se o registo atualizado se encontra na BD
        $this->test->dontSeeRecord('common\models\Artigo', ['descricao' => 'Caneta Preta Potente', 'nome' => 'Caneta Aluminio', 'referencia' => 'CAN001']);
        $this->test->seeRecord('common\models\Artigo', ['nome' => 'Update', 'preco' => 20.00, 'referencia' => 'CAN001', 'stock_atual' => 10]);

        //F - Apagar o registo
        $artigo->delete();
        //G - Verificar que o registo não se encontra na BD.
        $this->test->dontSeeRecord('common\models\Artigo', ['nome' => 'Update', 'preco' => 20.00, 'referencia' => 'CAN001', 'stock_atual' => 10]);
    }
}
