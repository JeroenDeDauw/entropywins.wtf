<?php

declare( strict_types = 1 );

namespace App\DataAccess\Blog;

interface BlogRepository {

	/**
	 * @return BlogPost[] The 10 latest blog posts
	 */
	public function getLatestPosts(): array;

}