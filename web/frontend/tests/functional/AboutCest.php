<?php

namespace frontend\tests\functional;

use frontend\tests\FunctionalTester;

class AboutCest
{
    public function checkAbout(FunctionalTester $I)
    {
        $I->amOnRoute('/');
        $I->see('About' );
        $I->seeLink('About');
        $I->click('About');


        $I->see('QUEM SOMOS');
    }
}
