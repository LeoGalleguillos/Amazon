<?php
namespace LeoGalleguillos\Amazon\Model\Service\Product\Products\Search;

use Generator;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class Results
{
    public function __construct(
        AmazonTable\ProductSearch $productSearchTable
    ) {
        $this->productSearchTable = $productSearchTable;
    }

    /**
     * @yield AmazonEntity\Product
     */
    public function getResults(
        string $query,
        int $page
    ): Generator {
        $productIds = $this->productSearchTable->selectProductIdWhereMatchAgainstLimit(
            $query,
            ($page - 1) * 100,
            100
        );

        foreach ($productIds as $productId) {
            yield $this->productFactory->buildFromProductId($productId);
        }
    }
}
