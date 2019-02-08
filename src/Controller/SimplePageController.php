<?php

declare( strict_types = 1 );

namespace App\Controller;

// phpcs:ignoreFile

use App\DataAccess\Blog\BlogPost;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class SimplePageController extends BaseController {

	public function index() {
		return $this->render(
			'pages/index.html.twig',
			[
				'posts' => $this->postsToTwigFormat(
					$this->getFactory()->newNewsRepository()->getLatestPosts()
				)
			]
		);
	}

	private function postsToTwigFormat( array $posts ): array {
		return array_map(
			function( BlogPost $post ) {
				return [
					'date' => $post->getDate(),
					'link' => $post->getLink(),
					'title' => $post->getTitle()
				];
			},
			$posts
		);
	}

	public function craftsmanship() {
		return $this->render(
			'pages/craftsmanship.html.twig',
			[
				'cleanPosts' => $this->postsToTwigFormat(
					$this->getFactory()->newNewsRepository()->getLatestWithTag( 'clean-code' )
				),
				'craftPosts' => $this->postsToTwigFormat(
					$this->getFactory()->newNewsRepository()->getLatestWithTag( 'software-craftsmanship' )
				)
			]
		);
	}

	public function smw() {
		return $this->render(
			'pages/smw.html.twig',
			[
				'posts' => $this->postsToTwigFormat(
					$this->getFactory()->newNewsRepository()->getLatestWithTag( 'smw' )
				)
			]
		);
	}

	public function wikidata() {
		return $this->render(
			'pages/wikidata.html.twig',
			[
				'posts' => $this->postsToTwigFormat(
					$this->getFactory()->newNewsRepository()->getLatestWithTag( 'wikidata' )
				)
			]
		);
	}

	public function page( string $page ) {
		if ( $page === 'projects' ) {
			return new RedirectResponse( 'open-source' );
		}

		return $this->render( 'pages/' . $page . '.html.twig' );
	}

	public function project( string $project ) {
		return $this->render(
			'pages/projects/' . $project . '.html.twig'
		);
	}

	public function notFound(): Response {
		$response = $this->render(
			'errors/404.html.twig'
		);

		$response->setStatusCode( 404 );

		return $response;
	}

}