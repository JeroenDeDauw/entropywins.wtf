<?php

use Silex\WebTestCase;

class SmokeTest extends WebTestCase {

	public function createApplication() {
		$app = require __DIR__ . '/../app/bootstrap.php';
		$app['debug'] = true;
		return $app;
	}

	public function testLibrariesPageIsTwoHundred() {
		$client = $this->createClient();

		$client->request( 'GET', '/libraries' );

		$this->assertSame( 200, $client->getResponse()->getStatusCode() );
	}

	public function testLibrariesPageHasBatchingIterator() {
		$client = $this->createClient();

		$client->request( 'GET', '/libraries' );

		$this->assertContains( 'Batching Iterator', $client->getResponse()->getContent() );
	}

	public function testHirePageHasRenderedMarkdown() {
		$this->markTestSkipped( 'Page not enabled' );
		$client = $this->createClient();

		$client->request( 'GET', '/hire' );

		$this->assertContains(
			'<h2>Professional approach</h2>',
			$client->getResponse()->getContent()
		);
	}

	public function testPageNotFound() {
		$this->app = require __DIR__ . '/../app/bootstrap.php';
		$client = $this->createClient();

		$client->request( 'GET', '/kittens' );

		$this->assertContains(
			'images/errors/404.jpg',
			$client->getResponse()->getContent()
		);
	}

}