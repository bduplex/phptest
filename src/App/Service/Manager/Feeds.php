<?php

namespace App\Service\Manager;

class Feeds
{
    private $loader;
    private $feeds;

    /**
     * Feeds constructor.
     *
     * @param \App\Service\Manager\FeedLoader $feedLoader
     * @param array                           $feeds
     */
    public function __construct(FeedLoader $feedLoader, array $feeds)
    {
        $this->loader = $feedLoader;
        $this->feeds = $feeds;
    }

    /**
     * @param $channel
     *
     * @return \SimpleXMLElement[]
     */
    public function getByChannel($channel)
    {
        $xml = $this->loader->load($this->feeds[$channel]);
        $channel = $xml->xpath('channel');

        return $channel;
    }

    /**
     * @param $category
     *
     * @return \SimpleXMLElement[]
     */
    public function getAllByCategory($category)
    {
        $results = [];

        foreach ($this->feeds as $feedUrl) {
            $feed = $this->loader->load($feedUrl);
            $results = array_merge(
                $results,
                $this->filterByCategory($feed, $category)
            );
        }

        return $results;
    }

    /**
     * @param $feed
     * @param $category
     *
     * @return \SimpleXMLElement[]
     */
    public function filterByCategory(\SimpleXMLElement $feed, $category)
    {
        return $feed->xpath("channel/item[category = '{$category}']");
    }
}
