<?php
namespace LeoGalleguillos\Amazon\Model\Service\Product\Products\Search;

use Generator;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class Results
{
    public function __construct(
        AmazonFactory\Product $productFactory,
        AmazonService\Product\Products\Search\SanitizedQuery $sanitizedQueryService,
        AmazonTable\ProductSearch $productSearchTable
    ) {
        $this->productFactory        = $productFactory;
        $this->sanitizedQueryService = $sanitizedQueryService;
        $this->productSearchTable    = $productSearchTable;
    }

    /**
     * @yield AmazonEntity\Product
     */
    public function getResults(
        string $query,
        int $page
    ): Generator {
        $sanitizedQuery = $this->sanitizedQueryService->getSanitizedQuery($query);

        $result = $this->productSearchTable->selectProductIdWhereMatchAgainstLimit(
            $sanitizedQuery,
            ($page - 1) * 100,
            100
        );

        foreach ($result as $array) {
            yield $this->productFactory->buildFromProductId((int) $array['product_id']);
        }
    }
}
