<?php

namespace backend\tests\functional;

use backend\tests\FunctionalTester;
use common\fixtures\UserFixture;
use common\models\Perfil;
use common\models\User;

/**
 * Class LoginCest
 */
class LoginCest
{
    /**
     * Load fixtures before db transaction begin
     * Called in _before()
     * @see \Codeception\Module\Yii2::_before()
     * @see \Codeception\Module\Yii2::loadFixtures()
     * @return array
     */
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
       /* $user = new User();
        $auth = \Yii::$app->authManager;
        $user->username = "admin";
        $user->email = "admin@brindes.com";
        $user->setPassword("teste123");
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        $user->save();
        $auth->assign($auth->getRole('Admin'), $user->getId());*/
        $authManager = \Yii::$app->authManager;
        $authManager->assign($authManager->getRole('Admin'), User::findOne(['username' => 'admin'])->id);


        $I->amOnRoute('/site/login');
    }
    protected function formParams($login, $password)
    {
        return [
            'LoginForm[username]' => $login,
            'LoginForm[password]' => $password,
        ];
    }
    
    /**
     * @param FunctionalTester $I
     */
    public function loginUser(FunctionalTester $I)
    {

        $I->amGoingTo('Tentar entrar com os dados corretos');
        $I->fillField('Username', 'APR');
        $I->fillField('Password', 'password_0');
        $I->click('login-button');

        $I->see('APR');
        $I->dontSeeLink('Login');
    }
    public function loginErrado(FunctionalTester $I)
    {

        $I->amGoingTo('Tentar entrar com os dados errados');
        $I->fillField('Username', 'Vaifalhar');
        $I->fillField('Password', '1234');
        $I->click('login-button');

        $I->see('Incorrect username or password.');
    }
    public function loginEmBranco(FunctionalTester $I)
    {

        $I->amGoingTo('Tentar entrar sem com os dados em branco');
        $I->fillField('Username', '');
        $I->fillField('Password', '');
        $I->click('login-button');

        $I->see('Username cannot be blank.');
        $I->see('Password cannot be blank.');
    }
    public function loginUserInativo(FunctionalTester $I){

        $I->amGoingTo('Tentar entrar com user inativo');
        $I->fillField('Username', 'userInativo9');
        $I->fillField('Password', 'teste123');
        $I->click('login-button');

        $I->see('Incorrect username or password.');
        $I->dontSeeLink('Home');
        $I->see('Login');
    }
    public function loginAdmin(FunctionalTester $I){


        $I->amGoingTo('Tentar entrar como admin');
        $I->fillField('Username', 'admin');
        $I->fillField('Password', 'teste123');
        $I->click('login-button');
        $I->see('admin');


    }

}
