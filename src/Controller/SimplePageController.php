<?php

declare( strict_types = 1 );

namespace App\Controller;

// phpcs:ignoreFile

use App\DataAccess\Blog\BlogPost;

class SimplePageController extends BaseController {

	public function index() {
		return $this->render(
			'pages/index.html.twig',
			[
				'posts' => array_map(
					function( BlogPost $post ) {
						return [
							'date' => $post->getDate(),
							'link' => $post->getLink(),
							'title' => $post->getTitle()
						];
					},
					$this->getFactory()->newNewsRepository()->getLatestPosts()
				)
			]
		);
	}

	public function page( string $page ) {
		return $this->render(
			'pages/' . $page . '.html.twig'
		);
	}

	public function project( string $project ) {
		return $this->render(
			'pages/projects/' . $project . '.html.twig'
		);
	}

}