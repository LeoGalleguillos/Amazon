<?php
namespace LeoGalleguillos\Amazon\Model\Service\ProductVideo\ProductVideos;

use Exception;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class Newest
{
    public function __construct(
        AmazonFactory\Product $productFactory,
        AmazonTable\ProductVideo $productVideoTable
    ) {
        $this->productFactory    = $productFactory;
        $this->productVideoTable = $productVideoTable;
    }

    public function getNewest()
    {
        foreach ($this->productVideoTable->selectAsinOrderByCreatedDesc() as $array) {
            $asin = $array['asin'];
            $productEntity = $this->productFactory->buildFromAsin($asin);
            $productVideoEntity = new AmazonEntity\ProductVideo();

            if (!preg_match('/^\w+$/', $asin)) {
                throw new Exception('Invalid ASIN (this should never happen)');
            }

            $productVideoEntity->setProduct($productEntity)
                               ->setRootRelativeUrl("/videos/products/$asin.mp4");

            yield $productVideoEntity;
        }
    }
}
