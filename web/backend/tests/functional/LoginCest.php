<?php

namespace backend\tests\functional;

use backend\tests\FunctionalTester;
use common\fixtures\UserFixture;

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
    
    /**
     * @param FunctionalTester $I
     */
    public function loginUser(FunctionalTester $I)
    {
        $I->amOnRoute('/site/login');
        $I->amGoingTo('Tentar entrar com os dados corretos');
        $I->fillField('Username', 'APR');
        $I->fillField('Password', 'password_0');
        $I->click('login-button');

        $I->see('APR');
        $I->dontSeeLink('Login');
        $I->dontSeeLink('Signup');
    }
    public function loginErrado(FunctionalTester $I)
    {
        $I->amOnRoute('/site/login');
        $I->amGoingTo('Tentar entrar com os dados errados');
        $I->fillField('LoginForm[username]', 'Vaifalhar');
        $I->fillField('LoginForm[password]', '1234');
        $I->click('Login');
        $I->see('Incorrect username or password.');
    }
    public function loginEmBranco(FunctionalTester $I)
    {
        $I->amOnRoute('/site/login');
        $I->amGoingTo('Tentar entrar sem com os dados em branco');
        $I->fillField('LoginForm[username]', '');
        $I->fillField('LoginForm[password]', '');
        $I->click('Login');
        $I->see('Username cannot be blank.');
        $I->see('Password cannot be blank.');
    }

}
