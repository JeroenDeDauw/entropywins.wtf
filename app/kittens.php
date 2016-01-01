<?php

function getPageHandler( $app, $pageName, array $arguments = [] ) {
	return function () use ( $app, $pageName, $arguments ) {
		foreach ( $arguments as &$argument ) {
			if ( is_callable( $argument ) ) {
				$argument = $argument();
			}
		}

		return $app['twig']->render(
			'pages/' . $pageName . '.html',
			array_merge( [
				'page' => $pageName,
			], $arguments )
		);
	};
}

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
	return blogPostsToHtmlListFunction( getBlogPostsFromUrlFunction( 'https://www.entropywins.wtf/blog/feed/' ) );
}

function getBlogPosts() {
	return blogPostsToHtmlFunction( getBlogPostsFromUrlFunction( 'https://www.entropywins.wtf/blog/feed/' ) );
}

function getBlogTopicLinks( $topic ) {
	return blogPostsToHtmlListFunction( getBlogPostsFromUrlFunction( 'https://www.entropywins.wtf/blog/tag/' . $topic . '/feed/', 5 ) );
}

