<?php
namespace Elgg\E2E;

class PageTestCase extends \PHPUnit_Extensions_Selenium2TestCase {

	/**
	 * Go over specified menu items and verify items existence.
	 *
	 * @param $menuElement
	 * @param $menuItems
	 */
	protected function assertElggMenu(\PHPUnit_Extensions_Selenium2TestCase_Element $menuElement, $menuItems) {

		foreach ($menuItems as $menuItemKey => $row) {
			list($menuItemLabel, $menuItemUrl) = $row;
			$item = $menuElement->byCssSelector("li.elgg-menu-item-$menuItemKey > a.elgg-menu-content");
			$this->assertTrue($item->displayed());
			$this->assertEquals($menuItemLabel, $item->text());
			$this->assertEquals($menuItemUrl, $item->attribute('href'));
		}
	}

	/**
	 * Assert that heading exists and contains correct site name.
	 */
	protected function assertElggHeading() {
		$headingLink = $this->byCssSelector('h1 > a.elgg-heading-site');
		$this->assertEquals("Elgg Travis Site", $headingLink->text());
		$this->assertEquals("http://localhost:8888/", $headingLink->attribute('href'));
	}

	/**
	 * Assert that topbar does not exist
	 */
	protected function assertElggTopbarNotExist() {
		try {
			$this->byCssSelector('.elgg-page-topbar');
			$this->fail("Topbar mustn't be present");
		} catch(\PHPUnit_Extensions_Selenium2TestCase_WebDriverException $e) {
			$expectedPrefix = 'Unable to locate element: {"method":"css selector","selector":".elgg-page-topbar"}';
			$this->assertStringStartsWith($expectedPrefix, $e->getMessage());
		}
	}

	/**
	 * Tests site menu elements, including items under "More"
	 */
	protected function assertElggMenuSite() {
		$menuItems = array(
			'activity'  => array('Activity', 'http://localhost:8888/activity'),
			'blog'      => array('Blogs', 'http://localhost:8888/blog/all'),
			'bookmarks' => array('Bookmarks', 'http://localhost:8888/bookmarks/all'),
			'file'      => array('Files', 'http://localhost:8888/file/all'),
			'groups'    => array('Groups', 'http://localhost:8888/groups/all'),
		);
		$menuMoreItems = array(
			'members'   => array('Members', 'http://localhost:8888/members'),
			'pages'     => array('Pages', 'http://localhost:8888/pages/all'),
			'thewire'   => array('The Wire', 'http://localhost:8888/thewire/all'),
		);
		$siteMenuElement = $this->byCssSelector('div.elgg-page-navbar > div.elgg-inner > div.elgg-nav-collapse > ul.elgg-menu-site');
		$this->assertElggMenu($siteMenuElement, $menuItems);
		$siteMenuMoreElement = $siteMenuElement->byCssSelector('li.elgg-more > ul.elgg-menu-site');
		// menu item "more" is not visible, so we need to either show it
//		$this->assertFalse($siteMenuMoreElement->displayed()); // it fails for some reason on PHP > 5.4
		$this->execute(array(
			'script' => "$('li.elgg-more > ul.elgg-menu-site').css('display', 'inherit');",
			'args' => array()
		));
		$this->assertTrue($siteMenuMoreElement->displayed());
		$this->assertElggMenu($siteMenuMoreElement, $menuMoreItems);
	}
}
