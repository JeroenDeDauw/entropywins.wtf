<?php

declare( strict_types = 1 );

namespace App\Tests\Unit\DataAccess\Blog;

use App\DataAccess\Blog\BlogPost;
use App\DataAccess\Blog\BlogRepository;
use App\DataAccess\Blog\WordpressApiBlogRepository;
use App\Tests\TestData;
use FileFetcher\FileFetcher;
use FileFetcher\SpyingFileFetcher;
use FileFetcher\StubFileFetcher;
use FileFetcher\ThrowingFileFetcher;
use PHPUnit\Framework\TestCase;

/**
 * @covers WordpressApiNewsRepository
 */
class WordpressApiBlogRepositoryTest extends TestCase {

	/**
	 * @var SpyingFileFetcher
	 */
	private $fileFetcher;

	public function setUp(): void {
		$this->fileFetcher = new SpyingFileFetcher( $this->newStubFetcher( 'three-posts.json' ) );
	}

	private function newStubFetcher( string $fileName ): FileFetcher {
		return new StubFileFetcher( TestData::getFileContents( 'blog/' . $fileName ) );
	}

	public function testWhenFileFetcherThrowsException_emptyArrayIsReturned() {
		$this->fileFetcher = new ThrowingFileFetcher();

		$this->assertSame( [], $this->newRepository()->getLatestPosts() );
	}

	private function newRepository(): BlogRepository {
		return new WordpressApiBlogRepository(
			$this->fileFetcher
		);
	}

	public function testWhenJsonIsValid_newsItemsAreReturned() {
		$items = $this->newRepository()->getLatestPosts();

		$this->assertContainsOnlyInstancesOf( BlogPost::class, $items );
		$this->assertNotEmpty( $items );
	}

	public function testWhenJsonIsInvalid_emptyArrayIsReturned() {
		$this->fileFetcher = new StubFileFetcher( '~=[,,_,,]:3' );

		$this->assertSame( [], $this->newRepository()->getLatestPosts() );
	}

	public function testWhenJsonIsValid_newsItemsContainCorrectValues() {
		$item = $this->newRepository()->getLatestPosts()[0];

		$this->assertSame( 'Readable Functions: Guard Clause', $item->getTitle() );
		$this->assertSame(
			'https://www.entropywins.wtf/blog/2019/01/14/readable-functions-guard-clause/',
			$item->getLink()
		);
		$this->assertSame( '2019-01-14T08:44:32', $item->getDate() );
	}

}
