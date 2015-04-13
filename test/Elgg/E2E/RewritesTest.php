<?php
namespace Elgg\E2E;

/**
 * Verify that all rewrites work properly.
 */
class RewritesTest extends PageTestCase
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
	public function testIndexPage()
	{
		$this->url('http://localhost:8888/');
		$this->assertEquals('Elgg Travis Site', $this->title());

//		$this->prepareSession();
//		$this->cookie()->get('Elgg');

		$this->assertElggHeading();
		$this->assertElggTopbarNotExist();
		$this->assertElggMenuSite();
	}

	/**
	 * Request /members page and verify it's contents.
	 */
	public function testHandlerRouting()
	{
		$this->url('http://localhost:8888/members');
		$this->assertEquals('Newest members : Elgg Travis Site', $this->title());

		$this->assertElggHeading();
		$this->assertElggTopbarNotExist();
		$this->assertElggMenuSite();

		/*
		 * test content
		 */
		$this->assertEquals("Newest members", $this->byCssSelector('h2.elgg-heading-main')->text());

	}
}
