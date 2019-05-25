<?php
namespace LeoGalleguillos\Amazon\Model\Service\ProductVideo\ProductVideos\BrowseNode\Name;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class NumberOfPages
{
    public function __construct(
        AmazonTable\ProductVideo $productVideoTable
    ) {
        $this->productVideoTable = $productVideoTable;
    }

    public function getNumberOfPages(
        string $browseNodeName
    ): int {
        $count = $this->productVideoTable->selectCountWhereBrowseNodeName(
            $browseNodeName
        );
        return ceil($count / 100);
    }
}
