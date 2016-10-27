<?php

use \Symfony\Component\HttpFoundation\Response;

$app = new Silex\Application();

# Uncomment if needed (on development)
#$app['debug'] = true;

$app['feed_sources'] = [
  "jobsinmalta" => "https://jobsinmalta.com/jobs.rss?exclude_recruitment_agencies=1&limit=5",
  "Konnect" => "https://www.konnekt.com/opportunities/feed",
  "Casttile" => "https://www.castilleresources.com/en/rss",
];

#
# Services
#
$app['feed_loader'] = function () {
    return new \App\Service\Manager\FeedLoader();
};

$app['feeds_manager'] = function ($app) {
    return new \App\Service\Manager\Feeds(
      $app['feed_loader'], 
      $app['feed_sources']
    );
};

$app['feed_xml_builder'] = function () {
    return new \App\Service\Builder\FeedXml();
};

#
# Routing & Controllers
#
$app->get('/list/{channel}', function ($channel) use ($app) {

    $channel = $app->escape($channel);

    if (!isset($app['feed_sources']["$channel"])) {
        $app->abort(404, "Job feed of {$channel} is not found");
    }

    $feeds = $app['feeds_manager']->getByChannel($channel);
    $xml = $app['feed_xml_builder']->build($feeds);

    return new Response($xml, 200, ['Content-Type' => 'application/xml']);
});

$app->get('/get/{category}', function ($category) use ($app) {
    $feeds = $app['feeds_manager']->getAllByCategory($app->escape($category));
    $xml = $app['feed_xml_builder']->build($feeds);

    return new Response($xml, 200, ['Content-Type' => 'application/xml']);
});

return $app;