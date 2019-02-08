<?php
namespace LeoGalleguillos\Amazon\Model\Service\ProductVideo\ProductVideos;

use Generator;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class BrowseNode
{
    public function __construct(
        AmazonFactory\ProductVideo $productVideoFactory,
        AmazonTable\ProductVideo $productVideoTable
    ) {
        $this->productVideoFactory = $productVideoFactory;
        $this->productVideoTable   = $productVideoTable;
    }

    public function getProductVideos(
        AmazonEntity\BrowseNode $browseNodeEntity,
        int $page
    ): Generator {
        $generator = $this->productVideoTable->selectWhereBrowseNodeId(
            $browseNodeEntity->getBrowseNodeId(),
            ($page - 1) * 100,
            100
        );
        foreach ($generator as $array) {
            yield $this->productVideoFactory->buildFromArray(
                $array
            );
        }
    }
}
