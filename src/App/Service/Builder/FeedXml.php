<?php

namespace App\Service\Builder;

class FeedXml
{
    /**
     * @param \SimpleXMLElement[] $data
     *
     * @return mixed
     */
    public function build($data)
    {
        $feed = new \SimpleXMLElement(
            $this->makeStructure($this->getContentPrepared($data)),
            LIBXML_NOCDATA
        );
        $feed->addAttribute('encoding', 'utf-8');

        return $feed->asXML();
    }

    /**
     * @param @param \SimpleXMLElement[] $data
     *
     * @return string
     */
    protected function getContentPrepared($data)
    {
        $content = '';

        foreach ($data as $xmlObject) {
            $content .= $xmlObject->asXML();
        }

        if ($content && $data[0]->getName() != 'channel') {
            $content = '<channel>' . $content . '</channel>';
        }

        return $content;
    }

    /**
     * @param $xmlContent
     *
     * @return string
     */
    protected function makeStructure($xmlContent)
    {
        $xmlString =
          '<?xml version="1.0"?>
       <?xml-stylesheet type="text/xsl" href="/xslt/list.xsl"?>
       <root xmlns:jobsinmalta="http://jobsinmalta.com/jobsinmalta-schema"
             xmlns:atom="http://www.w3.org/2005/Atom" version="2.0"
             jobsinmalta:noNamespaceSchemaLocation="http://jobsinmalta.com/jobsinmalta.xsd">' .
          $xmlContent .
          '</root>';

        return $xmlString;
    }
}
