<?php
namespace LeoGalleguillos\Amazon\Model\Service\ProductVideo\ProductVideos;

use Exception;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class Newest
{
    public function __construct(
        AmazonFactory\ProductVideo $productVideoFactory,
        AmazonTable\ProductVideo $productVideoTable
    ) {
        $this->productVideoFactory = $productVideoFactory;
        $this->productVideoTable   = $productVideoTable;
    }

    public function getNewest()
    {
        foreach ($this->productVideoTable->selectOrderByCreatedDesc() as $array) {
            $asin = $array['asin'];
            $productVideoEntity = $this->productVideoFactory->buildFromArray(
                $array
            );

            $productVideoEntity->setRootRelativeUrl("/videos/products/$asin.mp4");

            yield $productVideoEntity;
        }
    }
}
