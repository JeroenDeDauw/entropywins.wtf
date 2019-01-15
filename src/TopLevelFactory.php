<?php

declare( strict_types = 1 );

namespace App;

/**
 * Framework independent object graph construction
 */
class TopLevelFactory {

	private $container = [];

	public function __construct() {
	}

	/**
	 * @return mixed
	 */
	private function getSharedService( string $serviceName, callable $constructionFunction ) {
		if ( !array_key_exists( $serviceName, $this->container ) ) {
			$this->container[$serviceName] = $constructionFunction();
		}

		return $this->container[$serviceName];
	}

}
