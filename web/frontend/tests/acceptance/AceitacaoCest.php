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
        $I->fillField('Nome','clienteeeeee');
        $I->see('ORDER TOTAL');
        $I->see('Guardar e Emitir Fatura');
        //Guardar e Emitir Fatura
        $I->scrollTo('.btn.btn-primary');
        $I->wait(2);
        $I->click('Guardar e Emitir Fatura');
        $I->wait(2);

        //Ir ver fatura emitida na área de cliente
        $I->see('Home');
        $I->click('Home');
        $I->wait(2);
        $I->click('cliente');
        $I->see('Minhas Faturas');
        $I->click('Minhas Faturas');
        $I->see('Valor Fatura');
        //Remover fatura Emitida
        $I->click('Delete');
        $I->wait(2);
        //https://stackoverflow.com/questions/43526414/codeception-acceptance-test-to-accept-popup
        $I->acceptPopup('Ok');
        $I->wait(2);
        $I->dontSee('Emitida');
        $I->wait(2);

        //Criar de novo a fatura
        $I->click('Artigos');
        $I->see('Caneta Aluminio');
        $I->click('Caneta Aluminio');
        $I->wait(2);
        $I->see('Add Carrinho');
        $I->click('Add Carrinho');
        $I->see('CART SUMMARY');
        $I->see('Caneta Aluminio');
        $I->click('Proceed To Checkout');
        $I->wait(2);
        //Editar e Guardar Dados Fatura
        $I->see('MORADA DE FATURAÇÃO');
        //Altera o campo Nome Cliente
        $I->fillField('Nome','cliente');
        $I->see('ORDER TOTAL');
        $I->see('Guardar e Emitir Fatura');
        //Guardar e Emitir Fatura
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

        //Ver fatura paga
        $I->see('Valor Fatura');
        $I->click('View');
        $I->see('Paga');
        $I->wait(2);

        //Fazer avaliacao no artigo comprado
        $I->see('Categorias');
        $I->click('Categorias');
        $I->wait(2);
        $I->click('Canetas');
        $I->wait(2);
        $I->see('Caneta Aluminio');
        $I->click('Caneta Aluminio');
        $I->wait(2);
        $I->scrollTo('.btn.btn-primary');
        $I->fillfield('Comentário', 'Top');
        $I->selectOption('Classificação', '4');
        $I->scrollTo('.btn.btn-primary');
        $I->see('Deixe a sua avaliação');
        $I->click('Deixe a sua avaliação');
        $I->see('Caneta Preta Potente');
        $I->wait(2);

        //Alterar a password
        $I->see('Home');
        $I->click('Home');
        $I->wait(2);
        $I->click('cliente');
        $I->see('Ver Perfil');
        $I->click('Ver Perfil');
        $I->wait(2);
        $I->see('NIF');
        $I->click('Atualizar Dados');
        $I->wait(2);
        $I->see('Telefone');
        $I->see('Alterar Password');
        $I->seeElement('#alterar');
        $I->click('#alterar'); //https://codeception.com/docs/AcceptanceTests
        $I->wait(2);
        $I->see('Nova Password');
        $I->fillfield('Password Atual', 'teste123');
        $I->fillfield('Nova Password', 'teste12345');
        $I->fillfield('Confirmar Nova Password', 'teste12345');
        $I->wait(2);
        $I->click('Confirmar Alteração');
        $I->wait(2);
        $I->see('Morada');
        $I->wait(2);
        $I->see('Home');
        $I->click('Home');
        $I->wait(2);
        $I->click('cliente');
        $I->see('Ver Perfil');
        $I->click('Ver Perfil');
        $I->wait(2);
        $I->see('NIF');
        $I->click('Atualizar Dados');
        $I->wait(2);
        $I->see('Telefone');
        $I->see('Alterar Password');
        $I->seeElement('#alterar');
        $I->click('#alterar');
        $I->wait(2);
        $I->see('Nova Password');
        $I->fillfield('Password Atual', 'teste12345');
        $I->fillfield('Nova Password', 'teste123');
        $I->fillfield('Confirmar Nova Password', 'teste123');
        $I->wait(2);
        $I->click('Confirmar Alteração');
        $I->wait(2);
        //Logout
        $I->click('cliente');
        $I->see('Logout');
        $I->click('Logout');
        $I->wait(2);
        $I->see('Login');
        $I->see('Registo');
        $I->wait(2);
    }
}
