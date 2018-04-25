<?php
namespace LeoGalleguillos\Amazon\Model\Service\ProductGroup\RelatedProductEntities;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class NumberOfPages
{
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
        return 0;
    }
}
