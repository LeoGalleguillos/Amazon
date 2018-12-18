<?php
namespace LeoGalleguillos\Amazon\Model\Factory;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class ProductVideo
{
    public function __construct(
        AmazonFactory\Product $productFactory
    ) {
        $this->productFactory = $productFactory;
    }

    public function buildFromAsin(string $asin): AmazonEntity\ProductVideo
    {
        $productVideoEntity = new AmazonEntity\ProductVideo();

        return $productVideoEntity->setProduct(
            $this->productFactory->buildFromAsin($asin)
        );
    }
}
