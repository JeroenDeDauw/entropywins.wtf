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
				'top_page' => explode( '/', $pageName )[0]
			], $arguments )
		);
	};
}

function getBlogPostsFromUrlFunction( $url, $max = 0, $offset = 0 ) {
	return function() use ( $url, $max, $offset ) {
		$rssReader = new SimplePie();

		$rssReader->set_feed_url( $url );
		$rssReader->init();
		$rssReader->handle_content_type();

		return $rssReader->get_items( $offset, $max );
	};
}

function blogPostsToResponseModelFunction( callable $getBlogPosts ) {
	return function() use ( $getBlogPosts ) {
		$responseModel = [];

		/**
		 * @var SimplePie_Item $item
		 */
		foreach ( $getBlogPosts() as $item ) {
			$responseModel[] = [
				'title' => $item->get_title(),
				'link' => $item->get_permalink(),
				'date' => $item->get_date()
			];
		}

		return $responseModel;
	};
}

function getBlogPosts() {
	return blogPostsToResponseModelFunction( getBlogPostsFromUrlFunction( 'https://www.entropywins.wtf/blog/feed/' ) );
}

function getBlogTagResponseModel( $topic, $limit ) {
	return blogPostsToResponseModelFunction( getBlogPostsFromUrlFunction( 'https://www.entropywins.wtf/blog/tag/' . $topic . '/feed/', $limit ) );
}

function getBlogCategoryResponseModel( $topic, $limit ) {
	return blogPostsToResponseModelFunction( getBlogPostsFromUrlFunction( 'https://www.entropywins.wtf/blog/category/' . $topic . '/feed/', $limit ) );
}

function getHighlightsFunction() {
	return function() {
		$rssReader = new SimplePie();

		$rssReader->set_feed_url( 'https://www.youtube.com/feeds/videos.xml?channel_id=UCEzz-FwJaaHGC4MVdMIzayg' );
		$rssReader->init();
		$rssReader->handle_content_type();

		return array_map(
			function( SimplePie_Item $item ) {
				return [
					'url' => $item->get_link( 0 )
				];
			},
			$rssReader->get_items( 0, 3 )
		);
	};
}