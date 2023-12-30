<?php


namespace frontend\tests\Acceptance;

use common\fixtures\UserFixture;
use common\models\User;
use frontend\tests\AcceptanceTester;

class AceitacaoCest
{


    public function _before(AcceptanceTester $I)
    {
        $I->maximizeWindow();

    }

    protected function formParams($login, $password)
    {
        return [
            'LoginForm[username]' => $login,
            'LoginForm[password]' => $password,
        ];
    }
    // tests
    public function testAceitacaoGeral(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        /*
        // Realizar registo
        $I->see('Registo');
        $I->click('Registo');
        $I->see('Por favor preencha todos os campos para efetuar o registo:');
        $I->fillField('Username', 'Visitante');
        $I->fillField('Email', 'visitante@gmai.com');
        $I->fillField('Password','teste123');
        $I->fillField('Nome', 'Visitante');
        $I->fillField('Telefone', 987654321);
        $I->fillField('Nif', 123456789);
        $I->fillField('Morada','Rua de Leiria');
        $I->fillField('Localidade','Leiria');
        $I->fillField('Código Postal','2400-000');
        $I->click('Registar-se');
        $I->wait(2);
        $I->see('Canetas');*/

        //Realizar Login
        $I->see('Login');
        $I->click('Login');
        $I->submitForm('#login-form', $this->formParams('cliente', 'teste123'));
        $I->wait(2);
        $I->see('cliente');
        $I->dontSee('Login');

        //Procurar artigo
        $I->see('Categorias');
        $I->click('Categorias');
        $I->wait(2);
        $I->click('Canetas');
        $I->wait(2);
        $I->see('Caneta Aluminio');
        $I->click('Caneta Aluminio');
        $I->wait(2);
        $I->see('Add Favoritos');

        //Adicionar aos Favoritos
        $I->click('Add Favoritos');
        $I->wait(2);
        //Remover dos Favoritos
        $I->click('X');
        $I->wait(2);
        $I->dontSee('Caneta Aluminio');

        //Adicionar ao Carrinho
        $I->click('Artigos');
        $I->see('Caneta Aluminio');
        $I->click('Caneta Aluminio');
        $I->wait(2);
        $I->see('Add Carrinho');
        $I->click('Add Carrinho');
        $I->see('CART SUMMARY');
        $I->see('Caneta Aluminio');
        //Remover do carrinho usando o 'X'
        $I->click('X');
        $I->wait(2);
        $I->dontSee('Caneta Aluminio');


        //Adicionar novamente ao carrinho para concluir a compra
        $I->click('Artigos');
        $I->click('Caneta Aluminio');
        $I->wait(2);
        $I->see('Add Carrinho');
        $I->click('Add Carrinho');
        $I->wait(2);
        $I->see('Caneta Aluminio');
        //Adicionar + 1 a quantidade do artigo
        $I->click('+');
        //$I->see(); quantidade 2, tem que se descobrir como é
        $I->click('Proceed To Checkout');
        $I->wait(2);
        //Editar e Guardar Dados Fatura
        $I->see('MORADA DE FATURAÇÃO');
        //Altera o campo Nome Cliente e
        $I->see('ORDER TOTAL');
        $I->see('Guardar e Emitir Fatura');

        $I->scrollTo('.btn.btn-primary');
        $I->wait(2);
        $I->click('Guardar e Emitir Fatura');
        $I->wait(2);

        //Ver fatura Emitida e Pagar
        $I->see('Dados da Empresa:');
        $I->see('Dados do Cliente:');
        $I->see('Data da Encomenda');
        $I->see('Pagar');
        $I->click('Pagar');
        //Após pagar
        $I->dontSee('Pagar');

        //Ver todas as Faturas
        $I->see('Home');
        $I->click('Home');
        $I->wait(2);
        $I->click('cliente');
        $I->see('Minhas Faturas');
        $I->click('Minhas Faturas');

        $I->wait(2);


    }
}
