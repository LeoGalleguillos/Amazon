<?php
namespace LeoGalleguillos\Amazon\Model\Service\Product\Products;

use Generator;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class ProductGroup
{
    const MAX_NUMBER_OF_PAGES = 100;

    public function __construct(
        AmazonFactory\Product $productFactory,
        AmazonTable\Product\ProductGroup $productGroupTable
    ) {
        $this->productFactory    = $productFactory;
        $this->productGroupTable = $productGroupTable;
    }

    public function getProductEntities(
        AmazonEntity\ProductGroup $productGroupEntity,
        int $page = 1
    ): Generator {
        $result = $this->productGroupTable->selectWhereProductGroup(
            $productGroupEntity->getName(),
            ($page - 1) * 100,
            100
        );

        foreach ($result as $array) {
            yield $this->productFactory->buildFromArray($array);
        }
    }
}
