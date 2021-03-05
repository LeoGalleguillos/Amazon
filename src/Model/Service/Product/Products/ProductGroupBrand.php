<?php
namespace LeoGalleguillos\Amazon\Model\Service\Product\Products;

use Generator;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class ProductGroupBrand
{
    public function __construct(
        AmazonFactory\Product $productFactory,
        AmazonTable\Product\ProductGroupBrand $productGroupBrandTable
    ) {
        $this->productFactory           = $productFactory;
        $this->productGroupBrandTable = $productGroupBrandTable;
    }

    public function getProductEntities(
        AmazonEntity\ProductGroup $productGroupEntity,
        AmazonEntity\Brand $brandEntity
    ): Generator {
        $result = $this->productGroupBrandTable->selectWhereProductGroupBrand(
            $productGroupEntity->getName(),
            $brandEntity->getName()
        );

        foreach ($result as $array) {
            yield $this->productFactory->buildFromArray($array);
        }
    }
}
