<?php
namespace LeoGalleguillos\Amazon\Model\Service\Product\Products\Search;

use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class NumberOfResults
{
    public function __construct(
        AmazonTable\ProductSearch $productSearchTable
    ) {
        $this->productSearchTable = $productSearchTable;
    }

    public function getNumberOfResults(string $query): int
    {
        return $this->searchTable->selectCountWhereMatchAgainst(
            $query
        );
    }
}
