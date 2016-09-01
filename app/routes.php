<?php

/**
 * @var Silex\Application $app
 */

/**
 * These variables need to be in scope when this file is included:
 *
 * @var \Silex\Application $app
 */

require_once __DIR__ . '/kittens.php';

$app->get(
	'/',
	getPageHandler( $app, 'home', [ 'blogposts' => getBlogPosts() ] )
);

$app->get(
	'/home',
	getPageHandler( $app, 'home', [ 'blogposts' => getBlogPosts() ] )
);

$app->get(
	'/craftsmanship',
	getPageHandler( $app, 'craftsmanship', [
		'postscraftsmanship' => getBlogTagResponseModel( 'software-craftsmanship', 10 ),
		'postscleancode' => getBlogTagResponseModel( 'clean-code', 10 ),
	] )
);

$app->get(
	'/smw',
	getPageHandler( $app, 'smw', [
		'blogposts' => getBlogTagResponseModel( 'smw', 10 )
	] )
);

$app->get(
	'/wikidata',
	getPageHandler( $app, 'wikidata', [
		'blogposts' => getBlogTagResponseModel( 'wikidata', 10 )
	] )
);

$app->get(
	'/gaming',
	getPageHandler( $app, 'gaming', [
		'blogposts' => getBlogCategoryResponseModel( 'gaming', 10 ),
		'videos' => getHighlightsFunction()
	] )
);

$app->get(
	'/libraries',
	getPageHandler( $app, 'projects' )
);

$app->get(
	'/projects',
	getPageHandler( $app, 'projects' )
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
	'/projects/skynet',
	getPageHandler( $app, 'projects/skynet' )
);

$app->get(
	'/projects/galib',
	getPageHandler( $app, 'projects/galib' )
);

$app->get(
	'/projects/bn-converter-pro',
	getPageHandler( $app, 'projects/bn-converter' )
);

$app->get(
	'/projects/bn-library',
	getPageHandler( $app, 'projects/bn-library' )
);

$app->get(
	'/projects/bn-brute-force-hash-attacker',
	getPageHandler( $app, 'projects/bn-bfha' )
);

$app->get(
	'/projects/art-of-defence-se4',
	getPageHandler( $app, 'projects/aod-se4' )
);

$app->get(
	'/keybase.txt',
	function() {
		return file_get_contents( __DIR__ .  '/keybase.entropywins.wtf.txt' );
	}
);

$app->get(
	'/slides/{presentation}/',
	function( $presentation ) use ( $app ) {
		return $app->redirect( "/slides/$presentation/index.html" );
	}
);

