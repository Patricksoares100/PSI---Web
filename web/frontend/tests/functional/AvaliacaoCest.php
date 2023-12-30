<?php


namespace frontend\tests\Functional;

use common\fixtures\UserFixture;
use common\models\Fatura;
use common\models\LinhaFatura;
use common\models\User;
use frontend\tests\FunctionalTester;

class AvaliacaoCest
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


    public function testAtribuirAvaliacao(FunctionalTester $I)
    {
        //Realizar login e adicionar artigo ao carrinho antes de avaliar
        $I->amLoggedInAs(User::findByUsername('erau'));
        $I->amOnRoute('artigo/detail?id=1');
        $I->see('Caneta Aluminio');
        $I->see('ja vi melhores'); //avaliação já existente na base de dados
        $I->seeLink('Add Favoritos');
        $I->click('Add Carrinho');
        $I->see('Quantidade');

        $I->amGoingTo('Confirmar os itens do carrinho');
        $I->see('Caneta Aluminio');
        $I->seeLink('Proceed To Checkout');
        $I->click('Proceed To Checkout');

        $I->amGoingTo('Confirmar os dados de faturação');
        $I->see('MORADA DE FATURAÇÃO');
        $I->see('Guardar e Emitir Fatura');
        $I->click('Guardar e Emitir Fatura');

        //Entrar nos Artigos, Deixar avaliação vai estar disponivel
        $I->see('Artigos');
        $I->click('Artigos');
        $I->see('Caneta Aluminio');
        $I->click('Caneta Aluminio');

        //ver o titulo / form e buttom de enviar avaliação
        $I->see('Deixe uma Avaliação');
        $I->fillField('Avaliacao[comentario]', 'artigo muito bom');
        $I->selectOption('Avaliacao[classificacao]', '3');
        $I->see('Deixe a sua avaliação');
        $I->click('Deixe a sua avaliação'); // Ele parece passar e nao gravar, continua aparecer a avaliação antiga 'ja vi melhores'
        $I->see('artigo muito bom');
        $I->see('ja vi melhores'); // se colocar apenas este see, ele passa o teste, porque como nao gravou o de cima, consegue ver na vista sem erros

        //$I->see('erau');
        //$I->see('Minhas Avaliações');
        //$I->click('Minhas Avaliações');
        //$I->see('found');

        //$I->seeElement('a[title="View"]');
        //$I->seeElement('a[title="Edit"]');
        //$I->seeElement('a[title="Delete"]');
        //$I->see('artigo muito bom');
        //$I->see('5');

    }

    public function testeEscreverAvaliacaoSemComprar(FunctionalTester $I)
    {
        //Realizar login e ver detalhes do artigo
        $I->amLoggedInAs(User::findByUsername('erau'));
        $I->amOnRoute('artigo/detail?id=1');
        $I->see('Caneta Aluminio');
        $I->seeLink('Add Favoritos');
        $I->seeLink('Add Carrinho');


        //Testar se aparece o form ou a mensagem de deixar avaliação
        $I->dontSee('Deixe uma Avaliação');
        $I->dontSee('Deixe a sua avaliação');

    }

    public function testVerPropriasAvaliacoesSemAvaliacoes(FunctionalTester $I)
    {
        $I->amLoggedInAs(User::findByUsername('erau'));
        $I->amOnRoute('artigo/detail?id=1');
        $I->see('erau');
        $I->see('Minhas Avaliações');
        $I->click('Minhas Avaliações');
        $I->see('No results found');
    }
}
