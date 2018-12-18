<?php
namespace LeoGalleguillos\Amazon\Model\Service\ProductVideo\ProductVideos;

use Generator;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class Similar
{
    public function __construct(
        AmazonFactory\ProductVideo $productVideoFactory,
        AmazonTable\ProductVideo $productVideoTable
    ) {
        $this->productVideoFactory = $productVideoFactory;
        $this->productVideoTable   = $productVideoTable;
    }

    public function getSimilar(AmazonEntity\ProductVideo $productVideo): Generator
    {
        $query = $productVideo->getTitle();
        $asins = $this->productVideoTable->selectAsinWhereMatchAgainst($query);
        foreach ($asins as $asin) {
            yield $this->productVideoFactory->buildFromAsin($asin);
        }
    }
}
