<?php
namespace LeoGalleguillos\Amazon\Model\Service\Product\Products;

use Generator;
use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class Newest
{
    public function __construct(
        AmazonFactory\Product $productFactory,
        AmazonTable\Product\IsValidModifiedProductId $isValidModifiedProductIdTable
    ) {
        $this->productFactory                = $productFactory;
        $this->isValidModifiedProductIdTable = $isValidModifiedProductIdTable;
    }

    public function getNewestProducts(): Generator
    {
        $result = $this->isValidModifiedProductIdTable
            ->selectWhereIsValidEquals1OrderByModifiedDescLimit100();

        foreach ($result as $array) {
            yield $this->productFactory->buildFromArray($array);
        }
    }
}
