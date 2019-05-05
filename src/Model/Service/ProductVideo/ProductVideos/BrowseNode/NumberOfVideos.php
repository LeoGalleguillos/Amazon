<?php
namespace LeoGalleguillos\Amazon\Model\Service\ProductVideo\ProductVideos\BrowseNode;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class NumberOfVideos
{
    public function __construct(
        AmazonTable\ProductVideo $productVideoTable
    ) {
        $this->productVideoTable = $productVideoTable;
    }

    public function getNumberOfVideos(
        AmazonEntity\BrowseNode $browseNodeEntity
    ): int {
        return $this->productVideoTable->selectCountWhereBrowseNodeId(
            $browseNodeEntity->getBrowseNodeId()
        );
    }
}
