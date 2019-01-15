<?php

declare( strict_types = 1 );

namespace App;

use Symfony\Component\Stopwatch\Stopwatch;

class FactoryWrapper {

	private $factory;
	private $onBuildCallbacks = [];
	private $stopwatch;

	public function __construct( Stopwatch $stopwatch ) {
		$this->stopwatch = $stopwatch;
	}

	public function buildFactory() {
		if ( $this->factory !== null ) {
			throw new \RuntimeException( 'Already build' );
		}

		$this->factory = new TopLevelFactory(
			$this->stopwatch
		);

		$this->runOnBuildCallbacks( $this->factory );
	}

	public function onBuild( callable $onBuild ) {
		$this->onBuildCallbacks[] = $onBuild;
	}

	private function runOnBuildCallbacks( TopLevelFactory $factory ) {
		foreach ( $this->onBuildCallbacks as $callback ) {
			$callback( $factory );
		}
	}

	public function getFactory(): TopLevelFactory {
		return $this->factory;
	}

}
