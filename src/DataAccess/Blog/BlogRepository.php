<?php

declare( strict_types = 1 );

namespace App\DataAccess\Blog;

interface BlogRepository {

	/**
	 * @return BlogPost[] Implementations can choose how many posts to return
	 */
	public function getLatestPosts(): array;

	/**
	 * @param string $tag
	 *
	 * @return BlogPost[] Implementations can choose how many posts to return
	 */
	public function getLatestWithTag( string $tag ): array;

}