<?php
namespace LeoGalleguillos\Amazon\Model\Service\Product\Products\Search;

use Laminas\Db as LaminasDb;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class NumberOfResults
{
    public function __construct(
        AmazonService\Product\Products\Search\SanitizedQuery $sanitizedQueryService,
        AmazonTable\ProductSearch $productSearchTable
    ) {
        $this->sanitizedQueryService = $sanitizedQueryService;
        $this->productSearchTable    = $productSearchTable;
    }

    public function getNumberOfResults(string $query): int
    {
        $sanitizedQuery = $this->sanitizedQueryService->getSanitizedQuery($query);

        /* @var LaminasDb\Adapter\Driver\Pdo\Result */
        $result = $this->productSearchTable->selectCountWhereMatchAgainst(
            $sanitizedQuery
        );
        return (int) $result->current()['COUNT(*)'];
    }
}
