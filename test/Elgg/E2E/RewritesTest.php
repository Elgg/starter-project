<?php
namespace Elgg\E2E;

use SebastianBergmann\Exporter\Exception;

/**
 * Verify that all rewrites work properly.
 */
class RewritesTest extends \PHPUnit_Extensions_Selenium2TestCase
{
	protected function setUp()
	{
		parent::setUp();
		$this->setBrowser('firefox');
		$this->setBrowserUrl('http://localhost:8888/');
		$this->setDesiredCapabilities(array(
			'browserName' => 'firefox',
			'javascriptEnabled' => true,
			'cssSelectorsEnabled' => true,
		));
	}

	/**
	 * Just grab the main page and see if the html title matches.
	 */
	public function testTitle()
	{
		$this->url('http://localhost:8888/');
		$this->assertEquals('Elgg Travis Site', $this->title());
	}

	/**
	 * Request /members page and verify it's contents.
	 */
	public function testHandlerRouting()
	{
		$this->url('http://localhost:8888/members');
		$this->assertEquals('Newest members : Elgg Travis Site', $this->title());

		$headingLink = $this->byCssSelector('h1 > a.elgg-heading-site');
		$this->assertEquals("Elgg Travis Site", $headingLink->text());
		$this->assertEquals("http://localhost:8888/", $headingLink->attribute('href'));

		// test site menu
		$siteMenu = $this->byCssSelector('div.elgg-page-navbar > div.elgg-inner > div.elgg-nav-collapse > ul.elgg-menu-site');

		$menuItems = array(
			'activity'  => array('Activity', 'http://localhost:8888/activity'),
			'blog'      => array('Blogs', 'http://localhost:8888/blog/all'),
			'bookmarks' => array('Bookmarks', 'http://localhost:8888/bookmarks/all'),
			'file'      => array('Files', 'http://localhost:8888/file/all'),
			'groups'    => array('Groups', 'http://localhost:8888/groups/all'),
		);
		foreach ($menuItems as $menuItemKey => $row) {
			list($menuItemLabel, $menuItemUrl) = $row;
			$item = $siteMenu->byCssSelector("li.elgg-menu-item-$menuItemKey > a.elgg-menu-content");
			$this->assertEquals($menuItemLabel, $item->text());
			$this->assertEquals($menuItemUrl, $item->attribute('href'));
		}

		// test content
		$this->assertEquals("Newest members", $this->byCssSelector('h2.elgg-heading-main')->text());
	}
}
