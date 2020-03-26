<?php
namespace LeoGalleguillos\Amazon\Model\Service\Product\Products\Newest\BrowseNode\Name;

use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class NumberOfPages
{
    public function __construct(
        AmazonTable\Product\IsValidCreatedProductId $isValidCreatedProductIdTable
    ) {
        $this->isValidCreatedProductIdTable = $isValidCreatedProductIdTable;
    }

    public function getNumberOfPages(
        string $browseNodeName
    ): int {
        $result = $this->isValidCreatedProductIdTable
            ->selectCountWhereBrowseNodeNameLimit(
                $browseNodeName
            );
        $count = $result->current()['COUNT(DISTINCT `product`.`product_id`)'];
        return ceil($count / 100);
    }
}
