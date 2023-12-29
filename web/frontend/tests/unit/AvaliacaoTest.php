<?php

namespace frontend\tests\unit;

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

        $avaliacao->artigo_id = null;
        $this->assertFalse($avaliacao->validate(['artigo_id']));

        $avaliacao->perfil_id = null;
        $this->assertFalse($avaliacao->validate(['perfil_id']));
    }

    public function testDadosInvalidos()
    {
        $avaliacao = new Avaliacao();

        // Preencher campos com dados inválidos
        $avaliacao->comentario = 123;
        $avaliacao->artigo_id = 'abc';
        $avaliacao->perfil_id = 'def';

        // Verificar se é inválido
        $this->assertFalse($avaliacao->validate(['comentario']));
        $this->assertFalse($avaliacao->validate(['artigo_id']));
        $this->assertFalse($avaliacao->validate(['perfil_id']));
    }

    public function testGuardarAvaliacaoValida()
    {
        //alinea B C ficha 7
        $avaliacao = new Avaliacao();

        $avaliacao->comentario = 'Bom Produto';
        $avaliacao->artigo_id = 1;
        $avaliacao->perfil_id = 2;

        $avaliacao->save();

        $this->tester->seeRecord('common\models\Avaliacao', ['comentario' => 'Bom Produto', 'artigo_id' => 1, 'perfil_id' => 2]);
    //}

    //public function testUpdateAvaliacao(){
        // alineas D E F e G FIcha7
        //$old_avaliacao = $this->tester->grabRecord('common\models\Avaliacao', ['comentario' => 'Bom Produto', 'artigo_id' => 1, 'perfil_id' => 2]);

        $avaliacao->comentario = 'Podia ser Melhor';
        $avaliacao->artigo_id = 2;
        $avaliacao->perfil_id = 3;

        $avaliacao->save();
        $this->tester->dontSeeRecord('common\models\Avaliacao', ['comentario' => 'Bom Produto', 'artigo_id' => 1, 'perfil_id' => 2]);
        $this->tester->seeRecord('common\models\Avaliacao', ['comentario' => 'Podia ser Melhor', 'artigo_id' => 2, 'perfil_id' => 3]);

        $avaliacao->delete();
        $this->tester->dontSeeRecord('common\models\Avaliacao', ['comentario' => 'Podia ser Melhor', 'artigo_id' => 2, 'perfil_id' => 3]);
    }
}
