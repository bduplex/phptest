<?php

namespace App\Service\Manager;

class FeedLoader
{
    /**
     * @param $url
     *
     * @return \SimpleXMLElement
     */
    public function load($url)
    {
        return new \SimpleXMLElement(
          $this->loadWithCurl($url),
          LIBXML_NOCDATA | LIBXML_NOWARNING
        );
    }

    /**
     * @param $url
     *
     * @return mixed
     */
    protected function loadWithCurl($url)
    {
        $curl = curl_init();
        $header[] = "Accept: application/rss+xml,application/xml,text/xml";
        $header[] = "Cache-Control: max-age=0";
        $header[] = "Accept-Charset: utf-8;q=0.7,*;q=0.7";
        $header[] = "Accept-Language: en,en-us,en-gb;q=0.5";

        curl_setopt_array(
          $curl, [
            CURLOPT_URL => $url,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => 'gzip,deflate',
            CURLOPT_FAILONERROR => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS => 5
          ]
        );
        $feed = curl_exec($curl);

        if (curl_errno($curl)) {
            throw new \RuntimeException(
              'Curl error (' . curl_errno($curl) . '): ' . curl_error($curl),
              8801
            );
        }

        $httpCode = (int)curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if (!in_array($httpCode, [200, 301, 302], true)) {
            throw new \RuntimeException(
              "Unexpected HTTP status code: $httpCode",
              8802
            );
        }

        curl_close($curl);

        return $feed;
    }
}
