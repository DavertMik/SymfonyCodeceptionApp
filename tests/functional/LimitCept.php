<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('see only 20 pages are listed');
$I->havePages(40);
$I->amOnPage('/page');
$I->seeNumberOfElements('.page', 20);
