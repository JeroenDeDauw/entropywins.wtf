<?php

declare( strict_types = 1 );

namespace App\Tests\EdgeToEdge;

use App\Kernel;
use Symfony\Component\HttpKernel\Client;

/**
 * Environment state for a single test that makes a web request using BrowserKit\Client
 */
class RequestEnvironment {

	private $kernel;
	private $client;
	private $factory;

	public function __construct( Kernel $kernel, Client $client ) {
		$this->kernel = $kernel;
		$this->client = $client;
	}

	public function getKernel(): Kernel {
		return $this->kernel;
	}

	public function getClient(): Client {
		return $this->client;
	}

	public function __destruct() {
		$this->kernel->terminate( $this->client->getRequest(), $this->client->getResponse() );
	}

}