<?php

namespace frontend\tests\unit;

use common\models\Fatura;
use frontend\tests\UnitTester;

class FaturaTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    // tests
    public function testCamposObrigatorios()
    {
        $fatura = new Fatura();

        // A - Despoletar todas as regras de validação (introduzindo dados erróneos);
        $fatura->data = null;
        $this->assertFalse($fatura->validate(['data']));

        $fatura->valor_fatura = null;
        $this->assertFalse($fatura->validate(['valor_fatura']));

        $fatura->perfil_id = null;
        $this->assertFalse($fatura->validate(['perfil_id']));
    }

    public function testDadosInvalidos()
    {
        $fatura = new Fatura();

        // A- Despoletar todas as regras de validação (introduzindo dados erróneos);
        // Validar tipo de dados
        $fatura->data = null;
        $fatura->valor_fatura = 'abc';
        $fatura->estado = 10;
        $fatura->perfil_id = 'def';

        // Verificar se é inválido
        $this->assertFalse($fatura->validate(['data']));
        $this->assertFalse($fatura->validate(['valor_fatura']));
        $this->assertFalse($fatura->validate(['estado']));
        $this->assertFalse($fatura->validate(['perfil_id']));
    }

    public function testGuardarFaturaValida()
    {
        //B - Criar um registo válido e guardar na BD
        $fatura = new Fatura();

        $fatura->data = '2023-06-30 18:45:10';
        $fatura->valor_fatura = 18.99;
        $fatura->estado = 'Emitida';
        $fatura->perfil_id = 2;

        $this->assertTrue($fatura->save());
        //C - Ver se o registo válido se encontra na BD
        $this->tester->seeRecord('common\models\Fatura', ['data' => '2023-06-30 18:45:10', 'valor_fatura' => 18.99, 'estado' => 'Emitida', 'perfil_id' => 2]);
    }

    public function testUpdateFatura()
    {
        // alineas D E F e G FIcha7
        //D - Ler o registo anterior e aplicar um update
        $fatura = $this->tester->grabRecord('common\models\Fatura', ['data' => '2023-12-29 12:43:03', 'valor_fatura' => 6.15, 'estado' => 'Emitida', 'perfil_id' => 3]);

        $fatura->data = '2023-10-05 11:45:10';
        $fatura->valor_fatura = 189.99;
        $fatura->estado = 'Paga';
        $fatura->perfil_id = 3;

        $this->assertTrue($fatura->save());
        //E - Ver se o registo atualizado se encontra na BD
        $this->tester->dontSeeRecord('common\models\Fatura', ['data' => '2023-12-29 12:43:03', 'valor_fatura' => 6.15, 'estado' => 'Emitida', 'perfil_id' => 3]);
        $this->tester->seeRecord('common\models\Fatura', ['data' => '2023-10-05 11:45:10', 'valor_fatura' => 189.99, 'estado' => 'Paga', 'perfil_id' => 3]);

        //F - Apagar o registo
        $fatura->delete();
        //G - Verificar que o registo não se encontra na BD.
        $this->tester->dontSeeRecord('common\models\Fatura', ['data' => '2023-10-05 11:45:10', 'valor_fatura' => 189.99, 'estado' => 'Paga', 'perfil_id' => 3]);
    }
}
