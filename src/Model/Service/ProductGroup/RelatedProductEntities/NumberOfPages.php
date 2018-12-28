<?php
namespace LeoGalleguillos\Amazon\Model\Service\ProductGroup\RelatedProductEntities;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class NumberOfPages
{
    const MAX_NUMBER_OF_PAGES = 100;

    /**
     * Construct.
     */
    public function __construct(
        AmazonService\Product\ModifiedTitle $modifiedTitleService,
        AmazonTable\Search\ProductGroup $searchProductGroupTable
    ) {
        $this->modifiedTitleService    = $modifiedTitleService;
        $this->searchProductGroupTable = $searchProductGroupTable;
    }

    public function getNumberOfPages(
        AmazonEntity\Product $productEntity
    ) : int {
        $modifiedTitle = $this->modifiedTitleService->getModifiedTitle(
            $productEntity
        );
        $numberOfResults = $this->searchProductGroupTable
        ->selectCountWhereMatchTitleAgainstAndProductIdDoesNotEqual(
            $productEntity->getProductGroup()->getSearchTable(),
            $modifiedTitle,
            $productEntity->getProductId()
        );

        $numberOfPages = ceil($numberOfResults / 100);
        return ($numberOfPages > self::MAX_NUMBER_OF_PAGES)
             ? self::MAX_NUMBER_OF_PAGES
             : $numberOfPages;
    }
}
