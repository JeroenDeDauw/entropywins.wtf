<?php

declare( strict_types = 1 );

namespace App\Controller;

// phpcs:ignoreFile

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class NotFoundController extends BaseController {

	public function notFound( string $page ): Response {
		$redirects = [
			'projects' => 'open-source',
			'smw' => 'semantic-mediawiki',
		];

		if ( array_key_exists( $page, $redirects ) ) {
			return new RedirectResponse( $redirects[$page] );
		}

		return $this->newNotFoundResponse();
	}

	private function newNotFoundResponse() {
		$response = $this->render(
			'errors/404.html.twig'
		);

		$response->setStatusCode( 404 );

		return $response;
	}

}