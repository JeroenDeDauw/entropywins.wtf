<?php

declare( strict_types = 1 );

namespace App\Controller;

// phpcs:ignoreFile
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class SimplePageController extends AbstractController {

	public function index() {
		return $this->render(
			'pages/index.html.twig'
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