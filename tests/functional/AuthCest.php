<?php
use \FunctionalTester;

class AuthCest
{
    function _before(FunctionalTester $I)
    {
        $I->amOnPage('/demo/secured/login');
    }


    protected function logout(FunctionalTester $I)
    {
        $I->amOnPage('/demo/secured/hello/World');
        $I->seeLink('Logout');
        $I->click('Logout');
        $I->amOnPage('/demo/hello/World');
        $I->dontSee('logged in as');
    }

    /**
     * @after logout
     * @param FunctionalTester $I
     */
    public function authAsUser(FunctionalTester $I)
    {
        $I->fillField('Username', 'user');
        $I->fillField('Password', 'userpass');
        $I->click('Login');
        $I->expect('I am redirected to main page');
        $I->seeCurrentUrlEquals('/'); // redirected
        $I->amOnPage('/demo/secured/hello/World');
        $I->see('logged in as user', '#menu');
    }

    /**
     * @after logout
     * @param FunctionalTester $I
     */
    public function authAsAdmin(FunctionalTester $I)
    {
        $I->fillField('Username', 'admin');
        $I->fillField('Password', 'adminpass');
        $I->click('Login');
        $I->expect('I am redirected to secured page');
        $I->amOnPage('/demo/secured/hello/World');
        $I->see('logged in as admin', '#menu');
        $I->see('Hello resource secured');
        $I->click('Hello resource secured for admin only.');
        $I->see('Hello World secured for Admins only!', 'h1');
    }


}