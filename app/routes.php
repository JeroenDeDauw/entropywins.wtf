<?php

/**
 * @var Silex\Application $app
 */
use Symfony\Component\HttpFoundation\Request;

/**
 * These variables need to be in scope when this file is included:
 *
 * @var \Silex\Application $app
 */

require_once __DIR__ . '/kittens.php';

$app->get(
	'/',
	getPageHandler( $app, 'home', [ 'blogposts' => getBlogLinks() ] )
);

$app->get(
	'/home',
	getPageHandler( $app, 'home', [ 'blogposts' => getBlogLinks() ] )
);

$app->get(
	'/craftsmanship',
	getPageHandler( $app, 'craftsmanship', [ 'blogposts' => getBlogTopicLinks( 'software-craftsmanship' ) ] )
);

$app->get(
	'/smw',
	getPageHandler( $app, 'smw', [ 'blogposts' => getBlogTopicLinks( 'smw' ) ] )
);

$app->get(
	'/wikidata',
	getPageHandler( $app, 'wikidata', [ 'blogposts' => getBlogTopicLinks( 'wikidata' ) ] )
);

$app->get(
	'/libraries',
	getPageHandler( $app, 'libraries' )
);

$app->get(
	'/blog-embedded',
	getPageHandler( $app, 'blog-embedded', [ 'blogposts' => getBlogPosts() ] )
);

$app->get(
	'/slides',
	getPageHandler( $app, 'slides' )
);

$app->get(
	'/keybase.txt',
	function( Request $request ) {
		$file = substr( $request->getHost(), -3 ) === 'wtf' ? 'entropywins.wtf' : 'bn2vs.com';
		return file_get_contents( __DIR__ .  '/keybase.' . $file . '.txt' );
	}
);

