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