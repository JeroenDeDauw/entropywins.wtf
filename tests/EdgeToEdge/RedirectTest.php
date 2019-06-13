<?php

declare( strict_types = 1 );

namespace App\Tests\EdgeToEdge;

class RedirectTest extends EdgeToEdgeTestCase {

	public function testRedirect() {
		$response = $this->request( 'GET', 'smw' );

		$this->assertSame(
			302,
			$response->getStatusCode()
		);
	}

}