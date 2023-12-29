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

        // Preencher campos com dados inválidos
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
        //alinea B C ficha 7
        $fatura = new Fatura();

        $fatura->data = '2023-06-30 18:45:10';
        $fatura->valor_fatura = 18.99;
        $fatura->estado = 'Emitida';
        $fatura->perfil_id = 2;

        $fatura->save();

        $this->tester->seeRecord('common\models\Fatura', ['data' => '2023-06-30 18:45:10', 'valor_fatura' => 18.99, 'estado' => 'Emitida', 'perfil_id' => 2]);
    //}

        //public function testUpdateFatura(){
        // alineas D E F e G FIcha7
        //$old_$fatura = $this->tester->grabRecord('common\models\Fatura', ('common\models\Fatura', ['data' => '2023-06-30 18:45:10', 'valor_fatura' => 18.99, 'estado' => 'Emitida', 'perfil_id' => 2]);

        $fatura->data = '2023-10-05 11:45:10';
        $fatura->valor_fatura = 189.99;
        $fatura->estado = 'Paga';
        $fatura->perfil_id = 3;

        $fatura->save();
        $this->tester->dontSeeRecord('common\models\Fatura', ['data' => '2023-06-30 18:45:10', 'valor_fatura' => 18.99, 'estado' => 'Emitida', 'perfil_id' => 2]);
        $this->tester->seeRecord('common\models\Fatura', ['data' => '2023-10-05 11:45:10', 'valor_fatura' => 189.99, 'estado' => 'Paga', 'perfil_id' => 3]);

        $fatura->delete();
        $this->tester->dontSeeRecord('common\models\Fatura', ['data' => '2023-10-05 11:45:10', 'valor_fatura' => 189.99, 'estado' => 'Paga', 'perfil_id' => 3]);
    }
}
