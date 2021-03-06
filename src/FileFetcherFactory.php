<?php

declare( strict_types = 1 );

namespace App;

use FileFetcher\Cache\Factory as CacheFactory;
use FileFetcher\FileFetcher;
use FileFetcher\SimpleFileFetcher;
use FileFetcher\Stopwatch\Factory as StopwatchFactory;
use Psr\SimpleCache\CacheInterface;
use Symfony\Component\Cache\Psr16Cache;
use Symfony\Component\Stopwatch\Stopwatch;

class FileFetcherFactory {

	public static function newFileFetcher( Stopwatch $stopwatch, Psr16Cache $cache ): FileFetcher {
		return ( new StopwatchFactory() )->newStopwatchFetcher(
			self::newCachingFileFetcher( $cache ),
			$stopwatch
		);
	}

	private static function newCachingFileFetcher( CacheInterface $cache ): FileFetcher {
		return ( new CacheFactory() )->newCachingFetcher(
			new SimpleFileFetcher(),
			$cache,
			3600 * 24 * 7
		);
	}

}