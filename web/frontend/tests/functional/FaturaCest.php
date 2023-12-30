<?php


namespace frontend\tests\Functional;

use common\fixtures\UserFixture;
use common\models\User;
use frontend\tests\FunctionalTester;

class FaturaCest
{
    public function _fixtures()
    {
        return [
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'login_data.php'
            ]
        ];
    }
    public function _before(FunctionalTester $I)
    {
        $authManager = \Yii::$app->authManager;
        $authManager->assign($authManager->getRole('Cliente'), User::findOne(['username' => 'erau'])->id);
    }

    // tests
    public function testeGeralFatura(FunctionalTester $I)
    {
        //Realizar login e adicionar artigo ao carrinho
        $I->amLoggedInAs(User::findByUsername('erau'));
        $I->amOnRoute('artigo/detail?id=1');
        $I->see('Caneta Aluminio');
        $I->seeLink('Add Favoritos');
        $I->click('Add Carrinho');
        $I->see('Quantidade');

        //Teste as faturas
        $I->amGoingTo('Confirmar os itens do carrinho');
        $I->amOnRoute('linhacarrinho/index?id=1');
        $I->see('Caneta Aluminio');
        $I->seeLink('Proceed To Checkout');
        $I->click('Proceed To Checkout');

        $I->amGoingTo('Confirmar os dados de faturação');
        $I->see('MORADA DE FATURAÇÃO');
        $I->see('Guardar e Emitir Fatura');
        $I->click('Guardar e Emitir Fatura');

        $I->amGoingTo('Visualizar fatura emitida');
        $I->see('Dados da Empresa:');
        $I->see('Dados do Cliente:');
        $I->see('Data da Encomenda:');
        $I->see('Emitida');

        //Entrar no Minhas Faturas, Delete vai estar disponivel
        $I->see('Minhas Faturas');
        $I->click('Minhas Faturas');
        $I->see('Estado');
        $I->see('Emitida');
        $I->seeElement('a[title="View"]');
        $I->seeElement('a[title="Delete"]');
        $I->click('View');

        $I->amGoingTo('Pagar fatura');
        $I->seeLink('Pagar');
        $I->click('Pagar');

        $I->amGoingTo('Visualizar fatura paga');
        $I->see('Dados da Empresa:');
        $I->see('Dados do Cliente:');
        $I->see('Data de Pagamento:');
        $I->see('Paga');
        $I->dontSeeLink('Pagar');

        //Entrar no Minhas Faturas, não vai aparecer o Delete
        $I->see('Minhas Faturas');
        $I->click('Minhas Faturas');
        $I->see('Estado');
        $I->see('Paga');
        $I->seeElement('a[title="View"]');
        $I->dontSeeElement('a[title="Delete"]');

        $I->click('View');


        $I->amGoingTo('Visualizar a fatura para impressão');
        $I->seeLink('Imprimir');
        $I->click('Imprimir');
        $I->dontSee('Gerar PDF');
        $I->see('Caneta Aluminio');
        $I->dontSee('Imprimir');
        $I->dontSee('About');//cabeçalho
        $I->dontSee('ENTRE EM CONTATO CONOSCO');//footer
    }
    public function acederNaoLogado(FunctionalTester $I)
    {
        $I->amOnRoute('/site/index');
        $I->dontSee('Minhas Faturas');
        $I->see('Login');
    }
    public function acederLogado(FunctionalTester $I)
    {
        $I->amLoggedInAs(User::findByUsername('erau'));
        $I->amOnRoute('/site/index');
        $I->see('Minhas Faturas');
        $I->dontSee('Login');
        $I->click('Minhas Faturas');
        $I->see('Data');
        $I->see('Valor Fatura');
        $I->see('Estado');
    }

    public function deleteFaturaEmitida(FunctionalTester $I)
    {
        //Realizar login e adicionar artigo ao carrinho
        $I->amLoggedInAs(User::findByUsername('erau'));
        $I->amOnRoute('artigo/detail?id=1');
        $I->see('Caneta Aluminio');
        $I->seeLink('Add Favoritos');
        $I->click('Add Carrinho');
        $I->see('Quantidade');

        //Preparar fatura para apagar
        $I->amGoingTo('Confirmar os itens do carrinho');
        $I->amOnRoute('linhacarrinho/index?id=1');
        $I->see('Caneta Aluminio');
        $I->seeLink('Proceed To Checkout');
        $I->click('Proceed To Checkout');

        $I->amGoingTo('Confirmar os dados de faturação');
        $I->see('MORADA DE FATURAÇÃO');
        $I->see('Guardar e Emitir Fatura');
        $I->click('Guardar e Emitir Fatura');

        $I->amGoingTo('Visualizar fatura emitida');
        $I->see('Dados da Empresa:');
        $I->see('Dados do Cliente:');
        $I->see('Data da Encomenda:');
        $I->see('Emitida');

        //Entrar no Minhas Faturas, Delete vai estar disponivel
        $I->see('Minhas Faturas');
        $I->click('Minhas Faturas');
        $I->see('Estado');
        $I->see('Emitida');
        $I->seeElement('a[title="View"]');
        $I->seeElement('a[title="Delete"]');
        $I->click('a[title="Delete"]');
        $I->dontSee('Emitida');
        $I->see('No results found.');
        $I->see('Fatura removida com sucesso!');

    }

}
