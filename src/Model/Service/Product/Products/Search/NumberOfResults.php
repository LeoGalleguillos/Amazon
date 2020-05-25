<?php
namespace LeoGalleguillos\Amazon\Model\Service\Product\Products\Search;

use Laminas\Db as LaminasDb;
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
        /* @var LaminasDb\Adapter\Driver\Pdo\Result */
        $result = $this->productSearchTable->selectCountWhereMatchAgainst(
            $query
        );
        return (int) $result->current()['COUNT(*)'];
    }
}
