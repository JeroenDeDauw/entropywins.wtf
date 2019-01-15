<?php

declare( strict_types = 1 );

namespace App;

use FileFetcher\FileFetcher;
use FileFetcher\FileFetchingException;
use Symfony\Component\Stopwatch\Stopwatch;

class StopwatchFileFetcher implements FileFetcher {

	public const STOPWATCH_CATEGORY = 'file_fetcher';

	private $fileFetcher;
	private $stopwatch;
	private $category;

	public function __construct( FileFetcher $fileFetcher, Stopwatch $stopwatch, string $category = self::STOPWATCH_CATEGORY ) {
		$this->fileFetcher = $fileFetcher;
		$this->stopwatch = $stopwatch;
		$this->category = $category;
	}

	public function fetchFile( string $fileUrl ): string {
		$this->stopwatch->start( $fileUrl, $this->category );

		try {
			$fileContent = $this->fileFetcher->fetchFile( $fileUrl );
		}
		catch ( FileFetchingException $ex ) {
			throw $ex;
		}
		finally {
			$this->stopwatch->stop( $fileUrl );
		}

		return $fileContent;
	}

}
