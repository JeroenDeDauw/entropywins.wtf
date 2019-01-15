<?php

declare( strict_types = 1 );

namespace App\DataAccess\Blog;

use FileFetcher\FileFetcher;
use FileFetcher\FileFetchingException;

class WordpressApiBlogRepository implements BlogRepository {

	private const API_URL = 'https://www.entropywins.wtf/blog/wp-json/wp/v2/posts?';

	private $fileFetcher;

	public function __construct( FileFetcher $fileFetcher ) {
		$this->fileFetcher = $fileFetcher;
	}

	/**
	 * @return BlogPost[]
	 */
	public function getLatestPosts(): array {
		try {
			$postsArray = $this->getPostsArray();

		}
		catch ( FileFetchingException $ex ) {
			return [];
		}

		return $this->buildPostsFromArray( $postsArray );
	}

	private function getPostsArray(): array {
		$posts = json_decode(
			$this->fileFetcher->fetchFile( $this->getPostsUrl() ),
			true
		);

		if ( is_array( $posts ) ) {
			return $posts;
		}

		return [];
	}

	private function getPostsUrl(): string {
		return self::API_URL
			. http_build_query(
				[
					'per_page' => 10,
//					'tags' => $this->localeTagId
				]
			);
	}

	private function buildPostsFromArray( array $postsArray ): array {
		return array_map(
			function ( array $post ): BlogPost {
				return $this->newBlogPost( $post );
			},
			$postsArray
		);
	}

	private function newBlogPost( array $post ): BlogPost {
		return BlogPost::newInstance()
			->withTitle( $post['title']['rendered'] )
			->withLink( $post['link'] )
			->withDate( $post['date'] );
	}

}