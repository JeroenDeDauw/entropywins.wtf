<?php

declare( strict_types = 1 );

namespace App\DataAccess\Blog;

interface BlogRepository {

	/**
	 * @return BlogPost[]
	 */
	public function getLatestPosts(): array;

}