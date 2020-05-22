<?php
namespace LeoGalleguillos\Amazon\Model\Service\Product\Products;

use Generator;
use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class Newest
{
    public function __construct(
        AmazonFactory\Product $productFactory,
        AmazonTable\Product\IsValidCreatedProductId $isValidCreatedProductIdTable
    ) {
        $this->productFactory               = $productFactory;
        $this->isValidCreatedProductIdTable = $isValidCreatedProductIdTable;
    }

    public function getNewestProducts(): Generator
    {
        /*
         * @TODO Use table gateway and make sure result set excludes products
         * with null title.
         */
        $result = $this->isValidCreatedProductIdTable
            ->selectWhereIsValidEquals1OrderByCreatedDescLimit100();

        foreach ($result as $array) {
            yield $this->productFactory->buildFromArray($array);
        }
    }
}
