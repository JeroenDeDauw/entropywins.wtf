<?php

declare( strict_types = 1 );

namespace App\Tests\EdgeToEdge;

use Symfony\Component\Routing\Route;

class SmokeTest extends EdgeToEdgeTestCase {

	/**
	 * @dataProvider pagePathProvider
	 */
	public function testPagesDoNotError( RequestEnvironment $environment, string $pagePath ) {
		$environment->getClient()->request( 'GET', $pagePath );

		$this->assertSame(
			200,
			$environment->getClient()->getResponse()->getStatusCode()
		);
	}

	public function pagePathProvider(): iterable {
		$environment = $this->createEnvironment();

		/**
		 * @var $route Route
		 */
		foreach ( $environment->getKernel()->getContainer()->get( 'router' )->getRouteCollection() as $route ) {
			if ( $this->routeHasNoVariables( $route ) ) {
				yield [ $environment, $route->getPath() ];
			}
		}
	}

	private function routeHasNoVariables( Route $route ): bool {
		return strpos( $route->getPath(), '{' ) === false;
	}

}