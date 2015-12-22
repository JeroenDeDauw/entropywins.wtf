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



}