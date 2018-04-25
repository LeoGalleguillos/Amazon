<?php
namespace LeoGalleguillos\Amazon\Model\Service\ProductGroup;

use Generator;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class RelatedProductEntities
{
    /**
     * Construct.
     */
    public function __construct(
        AmazonFactory\Product $productFactory,
        AmazonService\Product\ModifiedTitle $modifiedTitleService,
        AmazonTable\Search\ProductGroup $searchProductGroupTable
    ) {
        $this->productFactory          = $productFactory;
        $this->modifiedTitleService    = $modifiedTitleService;
        $this->searchProductGroupTable = $searchProductGroupTable;
    }

    public function getRelatedProductEntities(
        AmazonEntity\Product $productEntity,
        int $page
    ) : Generator {
        $modifiedTitle = $this->modifiedTitleService->getModifiedTitle(
            $productEntity
        );
        $productIds = $this->searchProductGroupTable
        ->selectProductIdWhereMatchTitleAgainstAndProductIdDoesNotEqual(
            $productEntity->getProductGroupEntity()->getSearchTable(),
            $modifiedTitle,
            $productEntity->getProductId(),
            ($page - 1) * 100,
            100
        );

        foreach ($productIds as $productId) {
            yield $this->productFactory->buildFromProductId($productId);
        }
    }
}
