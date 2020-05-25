<?php
namespace LeoGalleguillos\Amazon\Model\Service\Product\Products\Search;

use Generator;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class Results
{
    public function __construct(
        AmazonFactory\Product $productFactory,
        AmazonTable\ProductSearch $productSearchTable
    ) {
        $this->productFactory     = $productFactory;
        $this->productSearchTable = $productSearchTable;
    }

    /**
     * @yield AmazonEntity\Product
     */
    public function getResults(
        string $query,
        int $page
    ): Generator {
        $result = $this->productSearchTable->selectProductIdWhereMatchAgainstLimit(
            $query,
            ($page - 1) * 100,
            100
        );

        foreach ($result as $array) {
            yield $this->productFactory->buildFromProductId((int) $array['product_id']);
        }
    }
}
