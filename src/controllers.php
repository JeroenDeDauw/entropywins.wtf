<?php

use Aptoma\Twig\Extension\MarkdownEngine\MichelfMarkdownEngine;
use Aptoma\Twig\Extension\MarkdownExtension;
use Symfony\Component\HttpFoundation\Response;

/**
 * @var Silex\Application $app
 */

$app['twig']->addExtension(new MarkdownExtension(new MichelfMarkdownEngine()));

$app->get('/', function () use ($app) {
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
