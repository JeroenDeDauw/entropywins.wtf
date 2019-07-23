<?php

declare( strict_types = 1 );

namespace App\Tests\EdgeToEdge;

use App\Kernel;
use FileFetcher\FileFetcher;
use FileFetcher\NullFileFetcher;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Client;

abstract class EdgeToEdgeTestCase extends TestCase {

	/**
	 * @see Client::request
	 */
	protected function request( string $method, string $uri, array $parameters = [],
		array $files = [], array $server = [], string $content = null ): Response {

		$environment = $this->createEnvironment();
		$environment->getClient()->request( ...func_get_args() );

		return $environment->getClient()->getResponse();
	}

	protected function createEnvironment(): RequestEnvironment {
		$kernel = new Kernel( 'test', true );

		$kernel->boot();
//		$kernel->getContainer()->set( FileFetcher::class, new NullFileFetcher() );

		/**
		 * @var Client $client
		 */
		$client = $kernel->getContainer()->get( 'test.client' );

//		$client->insulate();

		return new RequestEnvironment( $kernel, $client );
	}

	protected final function createClient(): Client {
		$environment = $this->createEnvironment();
		$client = $environment->getClient();

		// Hack to prevent the Kernel from being garbage collected while the client still exists
		$client->env = $environment;

		return $client;
	}

}
