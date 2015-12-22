<?php

use Silex\WebTestCase;

class SmokeTest extends WebTestCase {

	public function createApplication() {
		return require __DIR__ . '/../app/bootstrap.php';
	}

	public function testRootIsTwoHundred() {
		$client = $this->createClient();

		$client->request( 'GET', '/' );

		$this->assertSame( 200, $client->getResponse()->getStatusCode() );
	}

	public function testRootHasUnderConstruction() {
		$client = $this->createClient();

		$client->request( 'GET', '/' );

		$this->assertContains( 'Under construction', $client->getResponse()->getContent() );
	}

	public function testSmwPageHasSemanticMediaWiki() {
		$client = $this->createClient();

		$client->request( 'GET', '/smw' );

		$this->assertContains( 'Semantic MediaWiki', $client->getResponse()->getContent() );
	}

	public function testSmwPageHasRenderedMarkdown() {
		$client = $this->createClient();

		$client->request( 'GET', '/smw' );

		$this->assertContains(
			'<a href="https://www.ohloh.net/p/smw/contributors">contributors list on Ohloh</a>',
			$client->getResponse()->getContent()
		);
	}

}