<?php


namespace backend\tests\Unit;

use backend\tests\UnitTester;
use common\models\Empresa;

class EmpresaTest extends \Codeception\Test\Unit
{

    protected UnitTester $test;

    protected function _before()
    {
    }

    public function testCamposObrigatorios()
    {
        // A - Despoletar todas as regras de validação (introduzindo dados erróneos);
        //Validar empty
        $empresa = new Empresa();

        $empresa->nome = '';
        $this->assertFalse($empresa->validate(['nome']));

        $empresa->email = '';
        $this->assertFalse($empresa->validate(['email']));

        $empresa->telefone = null;
        $this->assertFalse($empresa->validate(['telefone']));

        $empresa->nif = null;
        $this->assertFalse($empresa->validate(['nif']));

        $empresa->morada = '';
        $this->assertFalse($empresa->validate(['morada']));

        $empresa->codigo_postal = '';
        $this->assertFalse($empresa->validate(['codigo_postal']));

        $empresa->localidade = '';
        $this->assertFalse($empresa->validate(['localidade']));
    }
    public function testDadosInvalidos()
    {
        $empresa = new Empresa();

        // A- Despoletar todas as regras de validação (introduzindo dados erróneos);
        // Validar int
        $empresa->telefone = 'abc';
        $empresa->nif = 'def';
        $this->assertFalse($empresa->validate(['telefone']));
        $this->assertFalse($empresa->validate(['nif']));

        // validar 9 algarismos
        // menos que 9
        $empresa->telefone = 12345678;
        $empresa->nif = 12345678;
        $this->assertFalse($empresa->validate(['telefone']));
        $this->assertFalse($empresa->validate(['nif']));
        //mais que 9
        $empresa->telefone = 1234567890;
        $empresa->nif = 1234567890;
        $this->assertFalse($empresa->validate(['telefone']));
        $this->assertFalse($empresa->validate(['nif']));
        // 9 certo, assertTrue
        $empresa->telefone = 123456789;
        $empresa->nif = 123456789;
        $this->assertTrue($empresa->validate(['telefone']));
        $this->assertTrue($empresa->validate(['nif']));

        //Validar max 255 caracteres
        $empresa->nome ='tolongnmmmameeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee';
        $empresa->email ='tolongnmmmameeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee';
        $this->assertFalse($empresa->validate(['nome']));
        $this->assertFalse($empresa->validate(['email']));

        //Validar min 2 caracteres
        $empresa->nome = 'a';
        $this->assertFalse($empresa->validate(['nome']));

        //Teste código-postal
        $empresa->codigo_postal = '1234567';
        $this->assertFalse($empresa->validate(['codigo_postal']));
        $empresa->codigo_postal = '12345678';
        $this->assertFalse($empresa->validate(['codigo_postal']));
        $empresa->codigo_postal = 'abcd-def';
        $this->assertFalse($empresa->validate(['codigo_postal']));

    }
    public function testGuardarEmpresaValido()
    {
        //B - Criar um registo válido e guardar na BD
        $empresa = new Empresa();

        $empresa->nome = 'Brindes';
        $empresa->email = 'brindes@zorro.pt';
        $empresa->telefone = 123456789;
        $empresa->nif = 123456789;
        $empresa->morada = 'Alto do Lena';
        $empresa->codigo_postal = '1234-456';
        $empresa->localidade = 'Leiria';

        $this->assertTrue($empresa->save());
        //C - Ver se o registo válido se encontra na BD
        $this->test->seeRecord('common\models\Empresa',['nome'=>'Brindes','localidade'=>'Leiria']);
    }
    public function testUpdateDeleteEmpresa(){
        //D - Ler o registo anterior e aplicar um update
        $empresa = $this->test->grabRecord('common\models\Empresa', ['nome' => 'Brindes','localidade'=>'7']);

        $empresa->nome = 'update';
        $empresa->email = 'update@zorro.pt';
        $empresa->telefone = 123456789;
        $empresa->nif = 123456789;
        $empresa->morada = 'teste update';
        $empresa->codigo_postal = '1234-456';
        $empresa->localidade = 'Leiria';

        $this->assertTrue($empresa->save());

        //E - Ver se o registo atualizado se encontra na BD
        $this->test->seeRecord('common\models\Empresa', ['nome' => 'update','email'=>'update@zorro.pt','morada'=>'teste update']);
        $this->test->dontSeeRecord('common\models\Empresa',['nome'=>'Brindes','localidade'=>'Leiria']);

        //F - Apagar o registo
        $empresa->delete();
        //G - Verificar que o registo não se encontra na BD.
        $this->test->dontSeeRecord('common\models\Empresa', ['nome' => 'update','email'=>'update@zorro.pt','morada'=>'teste update']);
    }
}
