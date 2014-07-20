<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('open welcome page');
$I->amOnPage('/');
$I->see('Welcome', 'h1');