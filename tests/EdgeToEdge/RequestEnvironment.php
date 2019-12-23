<?php

declare( strict_types = 1 );

namespace App\Tests\EdgeToEdge;

use App\Kernel;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

/**
 * Environment state for a single test that makes a web request using BrowserKit\Client
 */
class RequestEnvironment {

	private $kernel;
	private $client;

	public function __construct( Kernel $kernel, KernelBrowser $client ) {
		$this->kernel = $kernel;
		$this->client = $client;
	}

	public function getKernel(): Kernel {
		return $this->kernel;
	}

	public function getClient(): KernelBrowser {
		return $this->client;
	}

	public function __destruct() {
		$this->kernel->terminate( $this->client->getRequest(), $this->client->getResponse() );
	}

}