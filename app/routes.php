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
	getPageHandler( 'craftsmanship', [ 'blogposts' => getBlogTopicLinks( 'software-craftsmanship' ) ] )
);

$app->get(
	'/smw',
	getPageHandler( 'smw', [ 'blogposts' => getBlogTopicLinks( 'smw' ) ] )
);

$app->get(
	'/wikidata',
	getPageHandler( 'wikidata', [ 'blogposts' => getBlogTopicLinks( 'wikidata' ) ] )
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

function getBlogPostsFromUrlFunction( $url, $max = 0 ) {
	return function() use ( $url, $max ) {
		$rssReader = new SimplePie();

		$rssReader->set_feed_url( $url );
		$rssReader->init();
		$rssReader->handle_content_type();

		return $rssReader->get_items( 0, $max );
	};
}

function blogPostsToHtmlListFunction( callable $getBlogPosts ) {
	return function() use ( $getBlogPosts ) {
		// The derp is strong in this one
		// TODO: Should learn how to use twig properly :)
		$html = '';

		/**
		 * @var SimplePie_Item $item
		 */
		foreach ( $getBlogPosts() as $item ) {
			$pl = $item->get_permalink();
			$title = $item->get_title();
			$date = $item->get_date('j F Y | H:i');

			$html .= <<<EOL
		<li><a href="$pl">$title</a> <small>($date)</small></li>
EOL;

		}

		return '<ul>' . $html . '</ul>';
	};
}

function blogPostsToHtmlFunction( callable $getBlogPosts ) {
	return function() use ( $getBlogPosts ) {
		// The derp is strong in this one
		// TODO: Should learn how to use twig properly :)
		$html = '';

		/**
		 * @var SimplePie_Item $item
		 */
		foreach ( $getBlogPosts() as $item ) {
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
	};
}


function getBlogLinks() {
	$function = blogPostsToHtmlListFunction( getBlogPostsFromUrlFunction( 'https://www.entropywins.wtf/blog/feed/' ) );
	return $function();
}

function getBlogPosts() {
	$function = blogPostsToHtmlFunction( getBlogPostsFromUrlFunction( 'https://www.entropywins.wtf/blog/feed/' ) );
	return $function();
}

function getBlogTopicLinks( $topic ) {
	$function = blogPostsToHtmlListFunction( getBlogPostsFromUrlFunction( 'https://www.entropywins.wtf/blog/tag/' . $topic . '/feed/', 5 ) );
	return $function();
}

