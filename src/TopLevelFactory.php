<?php

declare( strict_types = 1 );

namespace App;

use App\DataAccess\Blog\BlogRepository;
use App\DataAccess\Blog\WordpressApiBlogRepository;
use FileFetcher\FileFetcher;
use FileFetcher\SimpleFileFetcher;
use Symfony\Component\Stopwatch\Stopwatch;

/**
 * Framework independent object graph construction
 */
class TopLevelFactory {

	private $container = [];

	public function __construct( Stopwatch $stopwatch ) {
		$this->container[Stopwatch::class] = $stopwatch;
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
				return new StopwatchFileFetcher(
					new SimpleFileFetcher(),
					$this->getStopwatch()
				);
			}
		);
	}

	public function setFileFetcher( FileFetcher $fileFetcher ) {
		$this->container[FileFetcher::class] = $fileFetcher;
	}

	private function getStopwatch(): Stopwatch {
		return $this->container[Stopwatch::class];
	}

}
