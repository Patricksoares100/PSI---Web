<?php

namespace frontend\tests\functional;

use common\fixtures\UserFixture;
use common\models\User;
use frontend\tests\FunctionalTester;

class CarrinhoCest
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
        $I->amOnRoute('/site/login');
    }

    //Carrinho não é acessivel por pessoas não autenticadas
    public function verificarNaoAutenticado(FunctionalTester $I)
    {
        $I->click('a[id="carrinho"]');
        $I->see('My Login');
    }

    //Verificar se esta acessivel depois de autenticado
    public function verificarAutenticado(FunctionalTester $I)
    {
        $I->see('Login');
        $I->fillField('Username', 'erau');
        $I->fillField('Password', 'password_0');
        $I->click('login-button');
        $I->see('Logout');
        $I->click('a[id="carrinho"]');
        $I->see('cart summary');
    }

    public function adicionarArtigoCarrinhoSemLogin(FunctionalTester $I)
    {
        $I->amOnRoute('artigo/detail?id=1');
        $I->see('Caneta Aluminio');
        $I->seeLink('Add Favoritos');
        $I->click('Add Carrinho');
        $I->see('My Login');
    }

    public function adicionarArtigoCarrinhoComLogin(FunctionalTester $I)
    {
        $I->amLoggedInAs(User::findByUsername('erau'));
        $I->amOnRoute('artigo/detail?id=1');
        $I->see('Caneta Aluminio');
        $I->seeLink('Add Favoritos');
        $I->click('Add Carrinho');
        $I->see('Quantidade');
    }

    public function adicionarMaisUmArtigoCarrinho(FunctionalTester $I)
    {
        $I->amLoggedInAs(User::findByUsername('erau'));
        $I->amOnRoute('artigo/detail?id=1');
        $I->see('Caneta Aluminio');
        $I->seeLink('Add Favoritos');
        $I->click('Add Carrinho');
        $I->see('Quantidade');

        $I->amGoingTo('Adicionar um Artigo');
        $I->see('Caneta Aluminio');
        $I->seeLink('+');
        $I->click('+');
        $I->see('2');
    }

    public function removerUmArtigoCarrinho(FunctionalTester $I)
    {
        $I->amLoggedInAs(User::findByUsername('erau'));
        $I->amOnRoute('artigo/detail?id=1');
        $I->see('Caneta Aluminio');
        $I->seeLink('Add Favoritos');
        $I->click('Add Carrinho');
        $I->see('Quantidade');

        $I->amGoingTo('Remover um Artigo');
        $I->see('Caneta Aluminio');
        $I->seeLink('-');
        $I->click('-');
        $I->see('1');
    }

    public function removerArtigoCarrinho(FunctionalTester $I)
    {
        $I->amLoggedInAs(User::findByUsername('erau'));
        $I->amOnRoute('artigo/detail?id=1');
        $I->see('Caneta Aluminio');
        $I->seeLink('Add Favoritos');
        $I->click('Add Carrinho');
        $I->see('Quantidade');

        $I->amGoingTo('Remover o item do carrinho');
        $I->see('valor iva');
        $I->seeLink('Home');
        $I->click('X');
        $I->dontSee('Caneta Aluminio');
    }
}
