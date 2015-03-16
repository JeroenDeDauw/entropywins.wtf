<?php

use Aptoma\Twig\Extension\MarkdownEngine\MichelfMarkdownEngine;
use Aptoma\Twig\Extension\MarkdownExtension;
use Symfony\Component\HttpFoundation\Response;

/**
 * @var Silex\Application $app
 */

$app['twig']->addExtension(new MarkdownExtension(new MichelfMarkdownEngine()));

$app->get('/', function () use ($app) {
	// TODO: learn how to access page name more sanely if possible
	return $app['twig']->render('index.html', ['page' => 'home']);
});

$app->get('/home', function () use ($app) {
	return $app['twig']->render('index.html', ['page' => 'home']);
});

$app->get('/libraries', function () use ($app) {
	return $app['twig']->render('libraries.html', ['page' => 'libraries']);
});

$app->get('/craftsmanship', function () use ($app) {
	return $app['twig']->render('craftsmanship.md', ['page' => 'craftsmanship']);
});

$app->get('/smw', function () use ($app) {
	return $app['twig']->render('smw.md', ['page' => 'smw']);
});

$app->get('/wikidata', function () use ($app) {
	return $app['twig']->render('wikidata.md', ['page' => 'wikidata']);
});

$app->get('/slides', function () use ($app) {
	return $app['twig']->render('slides.html', ['page' => 'slides']);
});

$app->get('/blog-embedded', function () use ($app) {
	// The derp is strong in this one
	// TODO: Should learn how to use twig properly :)
	$html = '';

	$rssReader = new SimplePie();
	$rssReader->set_feed_url( 'http://www.bn2vs.com/blog/feed/' );
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

	return $app['twig']->render('blog.html', ['page' => 'blog-embedded', 'blogposts' => $html]);
});

$app->error(function (\Exception $e, $code) use ($app) {
    if ($app['debug']) {
        return;
    }

    // 404.html, or 40x.html, or 4xx.html, or error.html
    $templates = array(
        'errors/'.$code.'.html',
        'errors/'.substr($code, 0, 2).'x.html',
        'errors/'.substr($code, 0, 1).'xx.html',
        'errors/default.html',
    );

    return new Response($app['twig']->resolveTemplate($templates)->render(['code' => $code]), $code);
});
