<?php

declare( strict_types = 1 );

namespace App\Tests\EdgeToEdge;

use Symfony\Component\Routing\Route;

class SmokeTest extends EdgeToEdgeTestCase {

	public function testPagesDoNotError() {
		$environment = $this->createEnvironment();

		foreach ( $this->getPagePaths( $environment ) as $path ) {
			$environment->getClient()->request( 'GET', $path );

			$this->assertSame(
				200,
				$environment->getClient()->getResponse()->getStatusCode(),
				'Page "' . $path . '" should not error'
			);
		}
	}

	private function getPagePaths( RequestEnvironment $environment ): iterable {
		/**
		 * @var $route Route
		 */
		foreach ( $environment->getKernel()->getContainer()->get( 'router' )->getRouteCollection() as $route ) {
			if ( $this->routeHasNoVariables( $route ) ) {
				yield $route->getPath();
			}
		}
	}

	private function routeHasNoVariables( Route $route ): bool {
		return strpos( $route->getPath(), '{' ) === false;
	}

}
