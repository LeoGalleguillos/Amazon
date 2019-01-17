<?php
namespace LeoGalleguillos\Amazon\Model\Service\BrowseNode\Name;

use Generator;
use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class NumberOfVideosNotGenerated
{
    public function __construct(
        AmazonTable\ProductBrowseNodeProductBrowseNode $productBrowseNodeProductBrowseNodeTable
    ) {
        $this->productBrowseNodeProductBrowseNodeTable = $productBrowseNodeProductBrowseNodeTable;
    }

    public function getNumberOfVideosNotGenerated(string $browseNodeName): int
    {
        return $this->productBrowseNodeProductBrowseNodeTable
            ->selectCountWhereProductVideoGeneratedIsNullAndBrowseNodeNameEquals(
                $browseNodeName
            );
    }
}
