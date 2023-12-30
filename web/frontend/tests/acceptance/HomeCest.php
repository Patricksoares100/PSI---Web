<?php

namespace frontend\tests\acceptance;

use frontend\tests\AcceptanceTester;
use yii\helpers\Url;

class HomeCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->maximizeWindow();
    }
    public function checkHome(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->see('Login');

        $I->seeLink('About');
        $I->click('About');
        $I->wait(2); // wait for page to be opened

        $I->see('QUEM SOMOS');
    }
}
