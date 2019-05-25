<?php
namespace LeoGalleguillos\Amazon\Model\Service\ProductVideo\ProductVideos\BrowseNode\Name\NotInBrowseNodeNameDomainArray;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class NumberOfPages
{
    public function __construct(
        AmazonService\BrowseNodeNameDomain\Names $namesService,
        AmazonTable\ProductVideo $productVideoTable
    ) {
        $this->namesService      = $namesService;
        $this->productVideoTable = $productVideoTable;
    }

    public function getNumberOfPages(): int {
        $count = $this->productVideoTable->selectCountWhereBrowseNodeNameNotIn(
            $this->namesService->getNames()
        );
        return ceil($count / 100);
    }
}
