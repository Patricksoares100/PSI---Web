<?php

namespace frontend\tests\functional;

use common\fixtures\UserFixture;
use common\models\Perfil;
use common\models\User;
use frontend\tests\FunctionalTester;

class FavoritoCest
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
        /*$user = new User();
        $auth = \Yii::$app->authManager;
        $user->username = "visitante";
        $user->email = "visitante@a.a";
        $user->setPassword("teste123");
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        $user->save();
        $auth->assign($auth->getRole('Cliente'), $user->getId());
        $perfil = new Perfil();
        $perfil->nome = "Visitante";
        $perfil->codigo_postal = "2000-123";
        $perfil->telefone = "912312312";
        $perfil->nif = "987987564";
        $perfil->morada = "rua xpto";
        $perfil->localidade = 'Porto';
        $perfil->id = $user->id;
        $perfil->save();*/
        $authManager = \Yii::$app->authManager;
        $authManager->assign($authManager->getRole('Cliente'), User::findOne(['username' => 'erau'])->id);



        $I->amOnRoute('/site/login');

    }

    //Favoritos não é acessivel por pessoas não autenticadas
    public function verificarNaoAutenticado(FunctionalTester $I)
    {
        $I->click('a[id="favorito"]');
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
        $I->click('a[id="favorito"]');
        $I->see('Favoritos');
    }

    public function adicionarArtigoFavoritosSemLogin(FunctionalTester $I)
    {

        $I->amOnRoute('artigo/detail?id=1');
        $I->see('Caneta Aluminio');
        $I->seeLink('Add Carrinho');
        $I->click('Add Favoritos');

        $I->see('My Login');
    }

    public function adicionarArtigoFavoritosComLogin(FunctionalTester $I)
    {
        $I->amLoggedInAs(User::findByUsername('erau'));
        $I->amOnRoute('artigo/detail?id=1');
        $I->see('Caneta Aluminio');
        $I->seeLink('Add Carrinho');
        $I->click('Add Favoritos');

        $I->see('Carrinho');
    }
}
