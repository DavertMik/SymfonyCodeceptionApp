<?php
use \FunctionalTester;
use \Codeception\Util\Locator;

class PageCrudCest
{
    private $pageRepo = 'Acme\DemoBundle\Entity\Page';
    private $pageId;
    
    public function _before(FunctionalTester $I)
    {
        $this->pageId = $I->haveInRepository($this->pageRepo, [
            'title' => 'hello world',
            'body' => 'long article'
        ]);
        $I->amOnPage('/page/');
        $I->see('hello world', '.records_list');
    }

    public function showPage(FunctionalTester $I)
    {
        $I->seeLink($this->pageId);
        $I->click($this->pageId);
        $I->seeInRepository($this->pageRepo, ['id' => $this->pageId]);
        $I->see('Page', 'h1');
        $I->see('hello world');
        $I->seeCurrentUrlEquals('/page/'.$this->pageId);
    }

    public function updatePage(FunctionalTester $I)
    {
        $I->seeLink('edit','/page/'.$this->pageId.'/edit');
        $I->click(Locator::href('/page/'.$this->pageId.'/edit'));
        $I->see('Page edit', 'h1');
        $I->fillField('Title', 'bye world');
        $I->click('Update');
        $I->amOnPage('/page');
        $I->see('bye world' ,'.records_list');
    }

    public function deletePage(FunctionalTester $I)
    {
        $I->click($this->pageId, '.records_list');
        $I->see('Page', 'h1');
        $I->click('Delete');
        $I->seeCurrentUrlEquals('/page/');
        $I->dontSee('hello world', '.records_list');
        $I->dontSeeInRepository($this->pageRepo, ['id' => $this->pageId]);
    }
}