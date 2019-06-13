<?php

declare( strict_types = 1 );

namespace App\Tests\EdgeToEdge;

use Symfony\Component\HttpFoundation\Response;

class PageNotFoundTest extends EdgeToEdgeTestCase {

	/**
	 * @dataProvider nonExistingPageProvider
	 */
	public function testPageNotFound( string $page ) {
		$response = $this->request( 'GET', $page );

		$this->assert404Response( $response );
	}

	private function assert404Response( Response $response ) {
		$this->assertContains(
			'404',
			$response->getContent()
		);

		$this->assertSame(
			404,
			$response->getStatusCode()
		);
	}

	public function nonExistingPageProvider(): iterable {
		yield [ '/derp' ];
		yield [ '/en/derp' ];
		yield [ '/en/derp/derp' ];
		yield [ '/mediawiki/derp' ];
	}

}