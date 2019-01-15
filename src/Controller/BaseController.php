<?php

declare( strict_types = 1 );

namespace App\Controller;

use App\FactoryWrapper;
use App\TopLevelFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BaseController extends AbstractController {

	private $wrapper;
	private $factory;

	public function __construct( FactoryWrapper $wrapper ) {
		$this->wrapper = $wrapper;
	}

	protected function getFactory(): TopLevelFactory {
		if ( $this->factory === null ) {
			$this->factory = $this->newFactory();
		}

		return $this->factory;
	}

	private function newFactory(): TopLevelFactory {
		$this->wrapper->buildFactory();
		return $this->wrapper->getFactory();
	}

}