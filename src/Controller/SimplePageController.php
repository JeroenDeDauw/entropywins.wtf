<?php

declare( strict_types = 1 );

namespace App\Controller;

// phpcs:ignoreFile

use App\DataAccess\Blog\BlogPost;
use App\DataAccess\Blog\BlogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SimplePageController extends AbstractController {

	public function index( BlogRepository $blogRepo ) {
		return $this->render(
			'pages/index.html.twig',
			[
				'posts' => $this->postsToTwigFormat(
					$blogRepo->getLatestPosts()
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

	public function craftsmanship( BlogRepository $blogRepo ) {
		return $this->render(
			'pages/craftsmanship.html.twig',
			[
				'cleanPosts' => $this->postsToTwigFormat(
					$blogRepo->getLatestWithTag( 'clean-code' )
				),
				'craftPosts' => $this->postsToTwigFormat(
					$blogRepo->getLatestWithTag( 'software-craftsmanship' )
				)
			]
		);
	}

	public function smw( BlogRepository $blogRepo ) {
		return $this->render(
			'pages/smw.html.twig',
			[
				'posts' => $this->postsToTwigFormat(
					$blogRepo->getLatestWithTag( 'smw' )
				)
			]
		);
	}

	public function wikidata( BlogRepository $blogRepo ) {
		return $this->render(
			'pages/wikidata.html.twig',
			[
				'posts' => $this->postsToTwigFormat(
					$blogRepo->getLatestWithTag( 'wikidata' )
				)
			]
		);
	}

	public function page( Request $request ): Response {
		return $this->render(
			'pages/' . $request->get( '_route' ) . '.html.twig'
		);
	}

	public function slides( string $page ): Response {
		if ( $page === 'fun-architecture' ) {
			return new RedirectResponse( 'https://jeroendedauw.github.io/fun-architecture/#/' );
		}
	}

	public function project( string $project ) {
		return $this->render(
			'pages/projects/' . $project . '.html.twig'
		);
	}

	public function sitemap(): Response {
		return $this->render(
			'sitemap.xml.twig',
			[
				'pages' => [
					'index' => 'daily',
					'open-source' => 'weekly',
					'craftsmanship' => 'weekly',
					'smw' => 'monthly',
					'wikidata' => 'monthly',
				]
			]
		);
	}

}