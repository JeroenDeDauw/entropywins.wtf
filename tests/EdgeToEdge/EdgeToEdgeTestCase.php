<?php

declare( strict_types = 1 );

namespace App\Tests\EdgeToEdge;

use App\Kernel;
use App\TopLevelFactory;
use FileFetcher\NullFileFetcher;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Client;

abstract class EdgeToEdgeTestCase extends TestCase {

	protected function createEnvironment(): RequestEnvironment {
		$kernel = new Kernel( 'test', true );

		$kernel->boot();

		$factory = $kernel->getContainer()->get( TopLevelFactory::class );

		$factory->setFileFetcher( new NullFileFetcher() );

		/**
		 * @var Client $client
		 */
		$client = $kernel->getContainer()->get( 'test.client' );

		return new RequestEnvironment( $kernel, $client, $factory );
	}

	/**
	 * @see Client::request
	 */
	protected function request( string $method, string $uri, array $parameters = [],
		array $files = [], array $server = [], string $content = null ): Response {

		$environment = $this->createEnvironment();
		$environment->getClient()->request( ...func_get_args() );

		return $environment->getClient()->getResponse();
	}

	protected final function createClient(): Client {
		$environment = $this->createEnvironment();
		$client = $environment->getClient();

		// Hack to prevent the Kernel from being garbage collected while the client still exists
		$client->env = $environment;

		return $client;
	}

}
