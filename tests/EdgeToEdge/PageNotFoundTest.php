<?php

declare( strict_types = 1 );

namespace App\Tests\EdgeToEdge;

class PageNotFoundTest extends EdgeToEdgeTestCase {

	public function testPageNotFound() {
		$response = $this->request( 'GET', '/en/derp' );

		$this->assertContains(
			'404',
			$response->getContent()
		);

		$this->assertSame(
			404,
			$response->getStatusCode()
		);
	}

}