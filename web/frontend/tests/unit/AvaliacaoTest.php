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

        // A - Despoletar todas as regras de validação (introduzindo dados erróneos);
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

        // A- Despoletar todas as regras de validação (introduzindo dados erróneos);
        // Validar string e int
        $avaliacao->comentario = 123;
        $avaliacao->artigo_id = 'abc';
        $avaliacao->perfil_id = 'def';
        /* Validar max 255 caracteres
        $avaliacao->comentario = 'tolongcommmeeennntttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttt';*/

        // Verificar se é inválido
        $this->assertFalse($avaliacao->validate(['comentario']));
        $this->assertFalse($avaliacao->validate(['artigo_id']));
        $this->assertFalse($avaliacao->validate(['perfil_id']));
    }

    public function testGuardarAvaliacaoValida()
    {
        //B - Criar um registo válido e guardar na BD
        $avaliacao = new Avaliacao();

        $avaliacao->comentario = 'Bom Produto';
        $avaliacao->artigo_id = 1;
        $avaliacao->perfil_id = 2;

        $this->assertTrue($avaliacao->save());
        //C - Ver se o registo válido se encontra na BD
        $this->tester->seeRecord('common\models\Avaliacao', ['comentario' => 'Bom Produto', 'artigo_id' => 1, 'perfil_id' => 2]);
    }

    public function testUpdateAvaliacao(){
        // alineas D E F e G FIcha7
        //D - Ler o registo anterior e aplicar um update
        $avaliacao = $this->tester->grabRecord('common\models\Avaliacao', ['comentario' => 'ja vi melhores', 'artigo_id' => 1, 'perfil_id' => 3]);

        $avaliacao->comentario = 'excelente artigo';
        $avaliacao->artigo_id = 1;
        $avaliacao->perfil_id = 3;

        $this->assertTrue($avaliacao->save());

        //E - Ver se o registo atualizado se encontra na BD
        $this->tester->dontSeeRecord('common\models\Avaliacao', ['comentario' => 'ja vi melhores', 'artigo_id' => 1, 'perfil_id' => 3]);
        $this->tester->seeRecord('common\models\Avaliacao', ['comentario' => 'excelente artigo', 'artigo_id' => 1, 'perfil_id' => 3]);

        //F - Apagar o registo
        $avaliacao->delete();
        //G - Verificar que o registo não se encontra na BD.
        $this->tester->dontSeeRecord('common\models\Avaliacao', ['comentario' => 'excelente artigo', 'artigo_id' => 1, 'perfil_id' => 3]);
    }
}
