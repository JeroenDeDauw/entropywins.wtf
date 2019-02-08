<?php

declare( strict_types = 1 );

namespace App\DataAccess\Blog;

use FileFetcher\FileFetcher;
use FileFetcher\FileFetchingException;

class WordpressApiBlogRepository implements BlogRepository {

	private const API_URL = 'https://www.entropywins.wtf/blog/wp-json/wp/v2/posts?';

	private $fileFetcher;
	private $maxPostCount;

	public function __construct( FileFetcher $fileFetcher ) {
		$this->fileFetcher = $fileFetcher;
		$this->maxPostCount = 10;
	}

	/**
	 * @return BlogPost[]
	 */
	public function getLatestPosts(): array {
		try {
			$postsArray = $this->getPostsArray( $this->getPostsUrl() );
		}
		catch ( FileFetchingException $ex ) {
			return [];
		}

		return $this->buildPostsFromArray( $postsArray );
	}

	private function getPostsArray( string $url ): array {
		$posts = json_decode(
			$this->fileFetcher->fetchFile( $url ),
			true
		);

		if ( is_array( $posts ) ) {
			return $posts;
		}

		return [];
	}

	private function getPostsUrl( array $parameters = [] ): string {
		return self::API_URL
			. http_build_query(
				array_merge(
					[
						'per_page' => $this->maxPostCount
					],
					$parameters
				)
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

	public function getLatestWithTag( string $tag ): array {
		// https://www.entropywins.wtf/blog/wp-json/wp/v2/tags?search=smw
		$tagMap = [
			'smw' => 237,
			'wikidata' => 305,
			'software-craftsmanship' => 365,
			'clean-code' => 328,
		];

		try {
			$postsArray = $this->getPostsArray( $this->getPostsUrl( [ 'tags' => $tagMap[$tag] ] ) );
		}
		catch ( FileFetchingException $ex ) {
			return [];
		}

		return $this->buildPostsFromArray( $postsArray );
	}

}