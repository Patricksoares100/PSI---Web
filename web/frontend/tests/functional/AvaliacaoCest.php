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

    protected function formParamsAvaliacao($comentario, $classificacao)
    {
        return [
            'Avaliacao[comentario]' => $comentario,
            'Avaliacao[classificacao]' => $classificacao,
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

        //Finalizar compra do artigo para conseguir deixar avaliação
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
        $I->see('Deixe a sua avaliação');

        //Vai classificar o artigo no form
        $I->fillfield('Comentário', 'Top');
        $I->selectOption('Classificação', '4');
        $I->submitForm('#formAvaliacao', $this->formParamsAvaliacao('Top', '4'));
        $I->see('Top');
        $I->see('ja vi melhores');

        //Acede ao menu do canto superior para ver avaliações
        $I->see('erau');
        $I->see('Minhas Avaliações');
        $I->click('Minhas Avaliações');
        $I->seeElement('a[title="View"]');
        $I->seeElement('a[title="Delete"]');
        //Vê a avaliação que realizou
        $I->see('Top');
        $I->see('4');

        //Apagar avaliação
        $I->amGoingTo('Testar apagar avaliação');
        $I->see('Minhas Avaliações');
        $I->click('Minhas Avaliações');
        $I->click('a[title="Delete"]');
        $I->dontSee('ja vi melhores');
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
