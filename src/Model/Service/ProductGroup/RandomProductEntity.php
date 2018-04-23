<?php
namespace LeoGalleguillos\Amazon\Model\Service\ProductGroup;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class RandomProductEntity
{
    public function __construct(
        AmazonFactory\Product $productFactory,
        AmazonTable\Product\ProductId $productIdTable
    ) {
        $this->productFactory = $productFactory;
        $this->productIdTable = $productIdTable;
    }

    public function getRandomProductEntity(
        AmazonEntity\ProductGroup $productGroupEntity
    ) : AmazonEntity\Product {
        $maxProductId = $this->productIdTable->selectMaxWhereProductGroup(
            $productGroupEntity->getName()
        );
        $randomProductIdLowerLimit = rand(1, $maxProductId);
        $productId = $this->productIdTable->selectWhereGreaterThanOrEqualToAndProductGroup(
            $randomProductIdLowerLimit,
            $productGroupEntity->getName()
        );
        return $this->productFactory->buildFromProductId(
            $productId
        );
    }
}
