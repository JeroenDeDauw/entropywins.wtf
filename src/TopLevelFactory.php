<?php

declare( strict_types = 1 );

namespace App;

use App\DataAccess\Blog\BlogRepository;
use App\DataAccess\Blog\WordpressApiBlogRepository;
use FileFetcher\FileFetcher;
use FileFetcher\SimpleFileFetcher;

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

	public function newNewsRepository(): BlogRepository {
		return new WordpressApiBlogRepository( $this->getFileFetcher() );
	}

	private function getFileFetcher(): FileFetcher {
		return $this->getSharedService(
			FileFetcher::class,
			function() {
				return new SimpleFileFetcher();
			}
		);
	}

	public function setFileFetcher( FileFetcher $fileFetcher ) {
		$this->container[FileFetcher::class] = $fileFetcher;
	}

}
