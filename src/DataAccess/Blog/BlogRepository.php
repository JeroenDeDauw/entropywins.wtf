<?php

declare( strict_types = 1 );

namespace App\DataAccess\Blog;

use Symfony\Component\Stopwatch\Stopwatch;

interface BlogRepository {

	/**
	 * @return BlogPost[]
	 */
	public function getLatestPosts(): array;

}