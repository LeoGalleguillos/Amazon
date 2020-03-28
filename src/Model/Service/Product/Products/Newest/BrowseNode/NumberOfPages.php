<?php
namespace LeoGalleguillos\Amazon\Model\Service\Product\Products\Newest\BrowseNode;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class NumberOfPages
{
    public function __construct(
        AmazonTable\BrowseNodeProduct $browseNodeProductTable
    ) {
        $this->browseNodeProductTable = $browseNodeProductTable;
    }

    public function getNumberOfPages(
        AmazonEntity\BrowseNode $browseNodeEntity
    ): int {
        $result = $this->browseNodeProductTable
            ->selectCountWhereBrowseNodeId(
                $browseNodeEntity->getBrowseNodeId()
            );
        $count = $result->current()['COUNT(*)'];

        $numberOfPages = ceil($count / 100);

        return ($numberOfPages > 100) ? 100 : $numberOfPages;
    }
}
