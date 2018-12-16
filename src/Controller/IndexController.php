<?php

declare( strict_types = 1 );

namespace App\Controller;

// phpcs:ignoreFile
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexController extends Controller {

	public function index() {
		return $this->render(
			'pages/home.html.twig'
		);
	}

}