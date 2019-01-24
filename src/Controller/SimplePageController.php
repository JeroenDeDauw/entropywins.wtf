<?php

declare( strict_types = 1 );

namespace App\Controller;

// phpcs:ignoreFile

use App\DataAccess\Blog\BlogPost;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

		$templateFile = 'pages/' . $page . '.html.twig';

		if ( !$this->templateExists( $templateFile ) ) {
			throw new NotFoundHttpException();
		}

		return $this->render( $templateFile );
	}

	private function templateExists( string $templateFile ): bool {
		return file_exists( $this->getParameter( 'kernel.project_dir' ) . '/templates/' . $templateFile );
	}

	public function project( string $project ) {
		return $this->render(
			'pages/projects/' . $project . '.html.twig'
		);
	}

}