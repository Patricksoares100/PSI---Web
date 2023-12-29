<?php


namespace common\tests\Unit;

use common\models\User;
use common\tests\UnitTester;
use common\models\Perfil;

class PerfilTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    // tests
    public function testCamposObrigatorios()
    {
        // A - Despoletar todas as regras de validação (introduzindo dados erróneos);
        //Validar empty
        $perfil = new Perfil();

        $perfil->nome = '';
        $this->assertFalse($perfil->validate(['nome']));

        $perfil->telefone = '';
        $this->assertFalse($perfil->validate(['telefone']));

        $perfil->nif = '';
        $this->assertFalse($perfil->validate(['nif']));

        $perfil->morada = '';
        $this->assertFalse($perfil->validate(['morada']));

        $perfil->codigo_postal = '';
        $this->assertFalse($perfil->validate(['codigo_postal']));

        $perfil->localidade = '';
        $this->assertFalse($perfil->validate(['localidade']));
    }
    public function testDadosInvalidos()
    {
        $perfil = new Perfil();
        // A- Despoletar todas as regras de validação (introduzindo dados erróneos);
        // Validar int
        $perfil->telefone = 'abc';
        $perfil->nif = 'def';
        $this->assertFalse($perfil->validate(['telefone']));
        $this->assertFalse($perfil->validate(['nif']));

        //Validar max 255 caracteres
        $perfil->nome ='tolongnmmmameeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee';
        $perfil->morada ='tolongnmmmameeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee';
        $perfil->localidade ='tolongnmmmameeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee';
        $this->assertFalse($perfil->validate(['nome']));
        $this->assertFalse($perfil->validate(['morada']));
        $this->assertFalse($perfil->validate(['localidade']));

        //Validar codigo Postal max
        $perfil->codigo_postal = '1234-1234';
        $this->assertFalse($perfil->validate(['codigo_postal']));
        $perfil->codigo_postal = '1234567';
        $this->assertFalse($perfil->validate(['codigo_postal']));
        $perfil->codigo_postal = '12345678';
        $this->assertFalse($perfil->validate(['codigo_postal']));
        $perfil->codigo_postal = 'abcd-def';
        $this->assertFalse($perfil->validate(['codigo_postal']));

        // validar 9 algarismos
        // menos que 9
        $perfil->telefone = 12345678;
        $perfil->nif = 12345678;
        $this->assertFalse($perfil->validate(['telefone']));
        $this->assertFalse($perfil->validate(['nif']));
        //mais que 9
        $perfil->telefone = 1234567890;
        $perfil->nif = 1234567890;
        $this->assertFalse($perfil->validate(['telefone']));
        $this->assertFalse($perfil->validate(['nif']));
    }
   /* public function testGuardarPerfilValido()
    {
        //B - Criar um registo válido e guardar na BD
        $perfil = new Perfil();
        $user = new User();
        $user->id = 4;

        $perfil->id = $user->id;
        $perfil->nome = 'cliente';
        $perfil->telefone = 123456789;
        $perfil->nif = 123456789;
        $perfil->morada = 'Alto do Lena';
        $perfil->codigo_postal = '1234-789';
        $perfil->localidade = 'Leiria';

        $perfil->save();

        //C - Ver se o registo válido se encontra na BD
        $this->tester->seeRecord('common\models\Perfil',['nome'=>'cliente','localidade'=>'Leiria']);
    }
*/
}
