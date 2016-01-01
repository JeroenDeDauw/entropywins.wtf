<?php

/**
 * @var Silex\Application $app
 */

/**
 * These variables need to be in scope when this file is included:
 *
 * @var \Silex\Application $app
 */

function getPageHandler( $pageName, array $arguments = [] ) {
	return function () use ( $pageName, $arguments ) {
		return $GLOBALS['app']['twig']->render(
			'pages/' . $pageName . '.html',
			array_merge( [
				'page' => $pageName,
			], $arguments )
		);
	};
}

$app->get(
	'/',
	getPageHandler( 'home', [ 'blogposts' => getBlogLinks() ] )
);

$app->get(
	'/home',
	getPageHandler( 'home', [ 'blogposts' => getBlogLinks() ] )
);

$app->get(
	'/craftsmanship',
	getPageHandler( 'craftsmanship' )
);

$app->get(
	'/smw',
	getPageHandler( 'smw' )
);

$app->get(
	'/wikidata',
	getPageHandler( 'wikidata' )
);

$app->get(
	'/libraries',
	getPageHandler( 'libraries' )
);

$app->get(
	'/blog-embedded',
	getPageHandler( 'blog-embedded', [ 'blogposts' => getBlogPosts() ] )
);

$app->get(
	'/slides',
	getPageHandler( 'slides' )
);

function getBlogPosts() {
	// The derp is strong in this one
	// TODO: Should learn how to use twig properly :)
	$html = '';

	$rssReader = new SimplePie();
	$rssReader->set_feed_url( 'http://www.entropywins.wtf/blog/feed/' );
	$rssReader->init();
	$rssReader->handle_content_type();

	/**
	 * @var SimplePie_Item $item
	 */
	foreach ( $rssReader->get_items() as $item ) {
		$pl = $item->get_permalink();
		$title = $item->get_title();
		$content = $item->get_content();
		$date = $item->get_date('j F Y | H:i');

		$html .= <<<EOL
		<div class="item">
			<h2><a href="$pl">$title</a></h2>
			<p><small>Posted on $date</small></p>
			$content
		</div>
EOL;

	}

	return $html;
}


function getBlogLinks() {
	// The derp is strong in this one
	// TODO: Should learn how to use twig properly :)
	$html = '';

	$rssReader = new SimplePie();
	$rssReader->set_feed_url( 'http://www.entropywins.wtf/blog/feed/' );
	$rssReader->init();
	$rssReader->handle_content_type();

	/**
	 * @var SimplePie_Item $item
	 */
	foreach ( $rssReader->get_items() as $item ) {
		$pl = $item->get_permalink();
		$title = $item->get_title();
		$date = $item->get_date('j F Y | H:i');

		$html .= <<<EOL
		<li><a href="$pl">$title</a> <small>($date)</small></li>
EOL;

	}

	return '<ul>' . $html . '</ul>';
}