<?php
namespace LeoGalleguillos\Amazon\Model\Service\ProductVideo\ProductVideos;

use Exception;
use LeoGalleguillos\Amazon\Model\Service as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Video\Model\Entity as VideoEntity;

class Newest
{
    public function __construct(
        AmazonFactory\ProductVideo $productVideoTable
        AmazonTable\ProductVideo $productVideoTable
    ) {
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
