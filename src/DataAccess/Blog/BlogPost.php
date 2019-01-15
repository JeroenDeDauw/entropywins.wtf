<?php

declare( strict_types = 1 );

namespace App\DataAccess\Blog;

class BlogPost {

	private $title;
	private $link;
	private $date;

	private function __construct() {
	}

	public static function newInstance(): self {
		return new self();
	}

	public function withTitle( string $title ): self {
		$this->title = $title;
		return $this;
	}

	public function withLink( string $link ): self {
		$this->link = $link;
		return $this;
	}

	public function withDate( string $date ): self {
		$this->date = $date;
		return $this;
	}

	public function getTitle(): string {
		return $this->title;
	}

	public function getLink(): string {
		return $this->link;
	}

	public function getDate(): string {
		return $this->date;
	}

}